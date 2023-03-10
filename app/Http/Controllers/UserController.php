<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**@var User */
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function userRegister(RegisterRequest $request){
        try {

            $request['password'] = md5($request['password']);

            $data = $request->toArray();

            if(!$this->model->create($data)){
                throw new \Exception("Error when trying to create user");
            }

            unset($data['password']);

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
}
