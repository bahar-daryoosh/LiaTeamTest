<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->userService = new UserService();
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->userService->index();
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        return $this->userService->create($request->all());
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->userService->show($id);
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        return $this->userService->update($request->all(),$id);

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->userService->softdelete($id);
    }
}
