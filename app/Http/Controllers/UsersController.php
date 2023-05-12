<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::paginate(5);
        if ($users) {
            return view('user.list', compact('users'));
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adminPage()
    {
        return view('user.add');
    }

    /**
     * @param SignupRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addAdmin(SignupRequest $request)
    {
        $data = $request->validated();
        $password = bcrypt($data['password']);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $password,
        ]);
        return redirect('/user');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        if ($admin) {
            $admin->delete();
            return redirect('/user');
        } else {
            return view('user.list')->with('error', 'Admin not found');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            return view('user.update', compact('user'));
        } else {
            return back();
        }
    }

    /**
     * @p
     * racts\View\View
     * @param SignupRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update(UpdatePasswordRequest $request)
    {
        $admin = User::findOrFail($request['id']);
        if ($admin) {
            $data = $request->validated();
            $password = bcrypt($data['password']);
            $admin->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $password,
            ]);
            return redirect('/user');
        }
    }
}
