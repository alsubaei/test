<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::select(
            'id',
            'name',
        )->get();
        return view('roleViews.index', compact('roles'));
    }

    public function create()
    {
        return  view('roleViews.create');
    }

    public function store(Request $request)
    {

        $rules = ([
            'createRoleName' => 'unique:roles,name',
        ]);
        $messages = (['createRoleName.unique' => 'Enter unique name']);
        $validator = Validator::make($request->all(), $rules,   $messages);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        // return $validator->errors();

        $role = new Role;
        $role->givePermissionTo($request->selectedPermissions);
        $role->name = $request->createRoleName;
        $role->save();

        return redirect()->route('roles.index');
    }

    public function show(int $role_id)
    {
        $role = Role::find($role_id)->toArray();
        $permission = Role::find($role_id);

        return view('roleViews.show', compact('role', 'permission'));
    }

    public function edit(int $role_id)
    {
        $role = Role::find($role_id);

        if (!$role)
            return redirect()->back();

        return  view('roleViews.edit', compact('role'));
    }

    public function update(Request $r, int $role_id)
    {

        $role = Role::find($role_id);
        if (!$role)
            return redirect()->back();

        $role->syncPermissions($r->selectedPermissions);
        $role->name = $r->editRoleName;
        $role->save();


        return redirect()->route('roles.index');
    }
    public function destroy(int $role_id)
    {
        $role = Role::find($role_id);
        if (!$role)
            return redirect()->back();
        $role->delete();

        return redirect()->route('roles.index');
    }
}

