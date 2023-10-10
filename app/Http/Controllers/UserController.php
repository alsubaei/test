<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'password')->get();
        return view('userViews.index', compact('users'));
    }

    public function create()
    {
        return view('userViews.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required:users,name',
            'email' => 'required|unique:users,email',
            'password' => 'min:5|required:users,password',
        ];
        $messages = [
            'email.unique' => 'This account already exists
            Please enter another account',
            'name.required' => 'Please enter the name here',
            'email.required' => 'Please enter the email here',
            'password.required' => 'Please enter the password',
            'password.min' => 'Please enter at least 5 characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInputs($request->all());
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->assignRole($request->roles);
        $user->save();

        return redirect()->route('users.index');
    }

    public function show(int $user_id)
    {
        $user = user::find($user_id)->toArray();
        $roles = user::find($user_id);

        return view('userViews.show', compact('user', 'roles'));
    }

    public function edit($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return redirect()->back();
        }

        return view('userViews.edit', compact('user'));
    }

    public function update(Request $r, int $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return redirect()->back();
        }

        $user->syncRoles($r->selectedRoles);
        $user->name = $r->editUserName;
        $user->email = $r->editUserEmail;
        $user->password = Hash::make($r->editUserPassword);
        $user->save();

        return redirect()->route('users.index');
    }

    public function reset(Request $data)
    {
        $user = User::find($data->id);
        if ($user->password) {
            $user->password = Hash::make($data->password);
            $user->save();
        }
        return redirect()->back();
    }
    public function destroy(int $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return redirect()->back();
        }
        $user->delete();

        return redirect()->route('users.index');
    }
}
