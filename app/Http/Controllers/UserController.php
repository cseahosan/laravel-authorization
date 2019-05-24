<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $this->authorize('userList', auth()->user());

        $users = User::with('role')->paginate(10);
        return view('users.index', compact('users'));
    }


    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id');
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        try{
            $user->update($request->all());
            return redirect()->route('users.index')->withStatus('Updated Successfully !');
        }catch (QueryException $e){
            redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function destroy(User $user)
    {
        try{
            $user->delete();
            return redirect()->route('users.index')->withStatus('Deleted Successfully !');
        }catch (QueryException $e){
            redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

}
