<?php

namespace App\Http\Controllers\Users;

use App\Entities\Users\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Users Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $users = User::where('name', 'like', '%'.$query.'%')
            ->with('roles')
            ->paginate(25);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $userData = $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|between:6,15',
            'role' => 'required|array',
        ]);

        if ($userData['password']) {
            $userData['password'] = bcrypt($userData['password']);
        } else {
            $userData['password'] = bcrypt(\Option::get('password_default', 'member'));
        }

        $userData['api_token'] = Str::random(32);

        $user = User::create($userData);

        $rolesData = array_map(function ($roleId) use ($user) {
            return [
                'user_id' => $user->id,
                'role_id' => $roleId,
            ];
        }, $userData['role']);

        \DB::table('user_roles')->insert($rolesData);

        flash(__('user.created'), 'success');

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        $userCurrentJobs = $user->jobs()
            ->whereHas('project', function ($query) {
                $query->whereIn('status_id', [2, 3]);
            })->with('tasks')->get();

        return view('users.show', compact('user', 'userCurrentJobs'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $langList = ['en' => __('lang.en'), 'id' => __('lang.id')];

        return view('users.edit', compact('user', 'langList'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $userData = $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users,email,'.$request->segment(2),
            'password' => 'nullable|required_with:password_confirmation|between:6,15',
            'role' => 'required|array',
            'lang' => 'required|string|in:en,id',
        ]);

        if ($userData['password']) {
            $userData['password'] = bcrypt($userData['password']);
        }
        $user->update($userData);

        \DB::table('user_roles')->where(['user_id' => $user->id])->delete();

        $rolesData = array_map(function ($roleId) use ($user) {
            return [
                'user_id' => $user->id,
                'role_id' => $roleId,
            ];
        }, $userData['role']);

        \DB::table('user_roles')->insert($rolesData);

        flash(__('user.updated'), 'success');

        return redirect()->route('users.edit', $user->id);
    }

    public function delete(User $user)
    {
        $this->authorize('delete', $user);

        return view('users.delete', compact('user'));
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        $request->validate([
            'user_id' => 'required',
        ]);

        if ($request->get('user_id')) {
            $user->delete();
            flash(__('user.deleted'), 'success');
        } else {
            flash(__('user.undeleted'), 'danger');
        }

        return redirect()->route('users.index');
    }
}
