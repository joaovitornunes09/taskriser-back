<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

     /**@var Task */
     protected $model;

     public function __construct(Task $task)
     {
         $this->model = $task;
     }



    public function registerTask(StoreTaskRequest $request){
        try {
            $user = $request->user();

            if(!$request->has("status_id") && !$request->get("status_id")){
                $request->merge(["status_id" => 1] );
            }

            $data               = $request->toArray();
            
            $data['created_by'] = $user->user_id;

            if(!$this->model->create($data)){
                throw new \Exception("Error when trying to create a new task.");
            }

            return response()->json([
                "status" => true,
                'message' => "Request successfully completed!",
                "data"  => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Failed when trying to perform request",
                "data"    => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    public function list(){
        try {
            $data = $this->model->get();

            return response()->json([
                "status" => true,
                'message' => "Request successfully completed!",
                "data"  => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Failed when trying to perform request",
                "data"    => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    public function listById($id){
        try {
            $data = $this->model->find($id);

            return response()->json([
                "status" => true,
                'message' => "Request successfully completed!",
                "data"  => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Failed when trying to perform request",
                "data"    => $e->getMessage()
            ], $e->getCode() ?: 500);
        }

    }

    public function listUserTasks(){
        try {
            $user = auth()->user();

            $data = $this->model->where("assigned_to",$user->user_id)->orWhere("visible_to_all", true)
                ->orWHere("created_by", $user->user_id)->get();

            return response()->json([
                "status" => true,
                'message' => "Request successfully completed!",
                "data"  => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Failed when trying to perform request",
                "data"    => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    public function updateTask(UpdateTaskRequest $request, $id){
        try {
            $user = $request->user();

            $data = $request->toArray();

            $task = $this->model->find($id);

            if(!$task->update($data)){
                throw new \Exception("Error when trying to update task.");
            };

            return response()->json([
                "status" => true,
                'message' => "Request successfully completed!",
                "data"  => $task
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Failed when trying to perform request",
                "data"    => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    public function deleteTask($id){
        try {
            $task = $this->model->find($id);

            if(!$task->delete()){
                throw new \Exception("Error when trying to delete task.");
            };

            return response()->json([
                "status" => true,
                'message' => "Request successfully completed!",
                "data"  => "Task deleted successfully!"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Failed when trying to perform request",
                "data"    => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
}
