<?php

namespace App\Http\Controllers\Users;

use App\Entities\Users\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $users = User::where('name', 'like', '%'.$query.'%')
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
            'name'     => 'required|min:5',
            'email'    => 'required|email|unique:users,email',
            'password' => 'nullable|between:6,15|confirmed',
            // 'password_confirmation' => 'required_with:password',
        ]);

        if (!$userData['password']) {
            $userData['password'] = \Option::get('password_default', 'member');
        }

        $user = User::create($userData);

        flash()->success(trans('user.created'));

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $userData = $request->validate([
            'name'                  => 'required|min:5',
            'email'                 => 'required|email|unique:users,email,'.$request->segment(2),
            'password'              => 'nullable|required_with:password_confirmation|between:6,15|confirmed',
            'password_confirmation' => 'required_with:password',
        ]);

        $user->update($userData);

        flash()->success(trans('user.updated'));
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
            flash(trans('user.deleted'), 'success');
        } else {
            flash(trans('user.undeleted'), 'error');
        }

        return redirect()->route('users.index');
    }

}
