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

            $data = $this->model
            ->select('tasks.id', 'tasks.description', 'tasks.title', 'tasks.visible_to_all', 'tasks.status',
                     'tasks.complete_until', 'tasks.assigned_to', 'tasks.created_at', 'tasks.updated_at',
                     'tasks.completed_in', 'users_created_by.name as created_by', 'users_completed_by.name as completed_by')
            ->join('users as users_created_by', 'tasks.created_by', '=', 'users_created_by.user_id')
            ->leftJoin('users as users_completed_by', 'tasks.completed_by', '=', 'users_completed_by.user_id')
            ->where('assigned_to', $user->name)
            ->orWhere('visible_to_all', true)
            ->orWhere('created_by', $user->user_id)
            ->get();

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
            ],  500);
        }
    }

    public function updateTask(UpdateTaskRequest $request, $id){
        try {
            $task = $this->model->find($id);

            if($request->has("status")){
                if($request->get("status") === 3){
                    $completedBy = $request->user()->user_id;
                    $completedIn = date("d/m/Y");
                }

                $status         =   $this->status->find($request->get("status"))->status;
                $request->request->remove("status");
            }

            if($request->has("complete_until")){

                $completeUntil = date( 'd/m/Y' , strtotime($request->get("complete_until")));
                $request->request->remove("complete_until");
            }

            $data = $request->toArray();

            if(isset($status)){
                $data["status"] = $status;
            }

            if(isset($completeUntil)) {
                $data['complete_until'] = $completeUntil;
            }

            if(isset($completedBy)) {
                $data['completed_by'] = $completedBy;
            }

            if(isset($completedIn)) {
                $data['completed_in'] = $completedIn;
            }



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
