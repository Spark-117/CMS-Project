<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Cache\RetrievesMultipleKeys;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Return_;

class RoleController extends Controller
{
    //
    public function index(){

        return view('admin.authorizations.roles.index', [
            'roles'=> Role::all()

            ]);
    }

    public function store(){

        request()->validate([
           'name'=> ['required']
        ]);

        Role::create([
            'name'=> Str::ucfirst(request('name')),
            'slug'=> Str::of(Str::lower(request('name')))->slug('-')

        ]);
        return back();
    }

    public function edit(Role $role){

        return view('admin.authorizations.roles.edit',[
            'role'=>$role,
            'permissions'=>Permission::all()
        ]);

    }

    public function update(Role $role){

        $role->name = Str::ucfirst(request('name'));
        $role->slug = Str::of(request('name'))->slug('-');

        // this is in case nothing is updated you dont get the session msg
        if($role->isDirty('name')){
            session()->flash('role-updated', 'Role Updated to '. request('name'));
            $role->save();
        } else {
            session()->flash('role-updated', 'Nothing as been updated '. request('name'));
        }
        Return back();

    }

    public function attach_permission(Role $role){

        $role->permissions()->attach(request('permission'));
        return back();

    }

    public function detach_permission(Role $role){

        $role->permissions()->detach(request('permission'));
        return back();

    }

    public function destroy(Role $role){

        $role->delete();
        session()->flash('role-deleted', 'Role '. $role->name . ' has been Obliterated');
        return back();

    }
}
