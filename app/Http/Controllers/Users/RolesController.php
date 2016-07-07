<?php

namespace App\Http\Controllers\Users;

use App\Entities\Users\Permission;
use App\Entities\Users\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Roles\CreateRequest;
use App\Http\Requests\Users\Roles\DeleteRequest;
use App\Http\Requests\Users\Roles\UpdateRequest;
use Illuminate\Http\Request;

class RolesController extends Controller {

	public function index(Request $req)
	{
		// $role = null;
		if ($req->has('act') && in_array($req->get('act'), ['show','edit','del'])) {
			$role = $this->requireById($req->get('id'));
			if ($req->get('act') == 'show') {
				$permissions = $this->getAllPermissions();
			}
		}

		$roles = Role::whereType(0)->get();
		return view('users.roles',compact('roles','role','permissions'));
	}

	public function store(CreateRequest $req)
	{
		$roleData = $req->except('_token');
		$roleData['type'] = 0; // Role Type
		$role = Role::create($roleData);
		flash()->success(trans('role.created'));
		return redirect()->route('roles.index');
	}

	public function update(UpdateRequest $req, $roleId)
	{
		$role = $this->requireById($roleId);
		$role->update($req->except(['_method','_token']));
		flash()->success(trans('role.updated'));
		return redirect()->back();
	}

	public function destroy(DeleteRequest $req, $roleId)
	{
		if ($roleId == $req->get('role_id'))
		{
			$role = $this->requireById($roleId);
			$role->permissions()->detach();
			$role->delete();

	        flash()->success(trans('role.deleted'));
		}
		else
			flash()->error(trans('role.undeleted'));

		return redirect()->route('roles.index');
	}

	public function updatePermissions(Request $req, $roleId)
	{
		$role = $this->requireById($roleId);
		if ($req->has('permission'))
	        $role->permissions()->sync($req->get('permission'));
	    else
	        $role->permissions()->detach();

		flash()->success(trans('role.updated'));
		return redirect()->back();
	}

	private function requireById($roleId)
	{
		return Role::findOrFail($roleId);
	}

	private function getAllPermissions()
	{
		return Permission::whereType(1)->get();
	}


}
