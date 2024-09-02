<?php

namespace App\Services;


use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserService
{


    public function __construct()
    {

    }

    public function index()
    {
        return User::all();
    }

    public function create($input)
    {
        $user = User::create($input);
        // $user = $this->dbFunction->dbTransaction([$this->userQuery, 'insert'], $input);
        return $user;
    }

    public function show($id){
        return User::findOrFail($id);
    }

    public function update($input,$id)
    {
        return User::findOrFail($id)->update($input)->save();
        // $this->userQuery->update($input['input'], $input['user_id']);

    }




    public function softDelete($user_id)
    {
        return User::find($user_id)->delete();
        // return $this->dbFunction->dbTransaction([$this->userQuery,'delete_avatar'],$user_id);
    }
}
