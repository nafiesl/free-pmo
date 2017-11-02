<?php

namespace App\Http\Controllers\Users;

use App\Entities\Users\User;
use App\Entities\Users\UsersRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\DeleteRequest;
use App\Http\Requests\Users\UpdateRequest;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    private $repo;

    public function __construct(UsersRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $users = $this->repo->getUsers($request->get('q'));
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $userData = $request->validate([
            'name'                  => 'required|min:5',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'between:6,15|confirmed',
            'password_confirmation' => 'required_with:password',
        ]);

        $user = $this->repo->create($userData);

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

    public function update(UpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $userData = $request->except(['_method', '_token', 'password_confirmation']);

        $user->update($userData);

        flash()->success(trans('user.updated'));
        return redirect()->route('users.edit', $user->id);
    }

    public function delete(User $user)
    {
        $this->authorize('delete', $user);

        return view('users.delete', compact('user'));
    }

    public function destroy(DeleteRequest $request, User $user)
    {
        $this->authorize('delete', $user);

        if ($request->get('user_id')) {
            $this->repo->delete($user->id);
            flash()->success(trans('user.deleted'));
        } else {
            flash()->error(trans('user.undeleted'));
        }

        return redirect()->route('users.index');
    }

}
