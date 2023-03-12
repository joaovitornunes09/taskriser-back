<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

     /**@var Task */
     protected $model;

    /**@var Task */
    protected $status;

     public function __construct(Task $task, Status $status)
     {
         $this->model = $task;
         $this->status = $status;
     }



    public function registerTask(StoreTaskRequest $request){
        try {
            $user = $request->user();

            if(!$request->has("status") && !$request->get("status")){
                $request->merge(["status" => 1] );
            }

            if($request->has("complete_until")){
                $completeUntil = date( 'd/m/Y' , strtotime($request->get("complete_until")));
                $request->request->remove("complete_until");
            }

            $status =   $this->status->find($request->get("status"))->status;

            $request->request->remove("status");


            $data   = $request->toArray();

            $data['status']         = $status;
            $data['created_by']     = $user->user_id;
            $data['complete_until'] = $completeUntil;

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
            ],$e->getCode() ?: 500);
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
            if($request->has("status")){
                $status         =   $this->status->find($request->get("status"))->status;
                $request->request->remove("status");
            }

            if($request->has("complete_until")){
                $completeUntil = date( 'd/m/Y' , strtotime($request->get("complete_until")));
                $request->request->remove("complete_until");
            }

            $data = $request->toArray();

            if($status){
                $data["status"] = $status;
            }

            if($completeUntil) {
                $data['complete_until'] = $completeUntil;
            }

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
