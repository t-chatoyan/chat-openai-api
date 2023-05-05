<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Admins;
use Illuminate\Http\Request;

class AdminsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $admins = Admins::paginate(5);
        if ($admins) {
            return view('admin.list', compact('admins'));
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adminPage()
    {
        return view('admin.add');
    }

    /**
     * @param SignupRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addAdmin(SignupRequest $request)
    {
        $data = $request->validated();
        $password = bcrypt($data['password']);
        Admins::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $password,
        ]);
        return redirect('/admins');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function destroy($id)
    {
        $admin = Admins::findOrFail($id);
        if ($admin) {
            $admin->delete();
            return redirect('/admins');
        } else {
            return view('admin.list')->with('error', 'Admin not found');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $admin = Admins::findOrFail($id);
        if ($admin) {
            return view('admin.update', compact('admin'));
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
        $admin = Admins::findOrFail($request['id']);
        if ($admin) {
            $data = $request->validated();
            $password = bcrypt($data['password']);
            $admin->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $password,
            ]);
            return redirect('/admins');
        }
    }
}
