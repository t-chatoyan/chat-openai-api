<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::where('id', '!=', auth('admin')->id())->paginate(15);

        return view('admin.list', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:55',
            'email' => 'required|unique:admins|max:300',
            'password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8'
        ]);
        $data = $validated;
        $data['password'] = bcrypt($validated['password']);

        Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        return redirect(route('admin.index'))->with('status', 'New Admin was created!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin) {
            return view('admin.update', compact('admin'));
        } else {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:55',
            'email'=>'required|string|email|max:255|unique:admins,email,'.$id,
        ]);

        $admin = Admin::findOrFail($id);

        $admin->update($validated);
        return redirect(route('admin.index'))->with('status', ' Admin was updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect(route('admin.index'))->with('status', ' Admin was deleted successfully!');
    }
}
