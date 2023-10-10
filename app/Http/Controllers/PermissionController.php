<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function permissionAction()
    {
        $permissions = Permission::select(
            'id',
            'name'
        )->get();
        return view('permissionViews.all', compact('permissions'));
    }
}
