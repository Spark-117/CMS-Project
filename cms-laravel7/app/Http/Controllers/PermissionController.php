<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    //
    public function index(){

        return view('admin.authorizations.permissions.index',[
            'permissions'=>Permission::all()
            ]);

    }

    public function store(){

        request()->validate([
            'name'=> ['required']
        ]);

        Permission::create([
            'name'=> Str::ucfirst(request('name')),
            'slug'=> Str::of(Str::lower(request('name')))->slug('-')

        ]);
        return back();
    }

    public function edit(Permission $permission){

        return view('admin.authorizations.permissions.edit', ['permission'=>$permission]);

    }

    public function update(Permission $permission){

        $permission->name = Str::ucfirst(request('name'));
        $permission->slug = Str::of(request('name'))->slug('-');

        // this is in case nothing is updated you dont get the session msg
        if($permission->isDirty('name')){
            session()->flash('permission-updated', 'Permission Updated to '. request('name'));
            $permission->save();
        } else {
            session()->flash('permission-updated', 'Nothing as been updated '. request('name'));
        }
        Return back();

    }

    public function destroy(Permission $permission){

        $permission->delete();
        return back();

    }
}
