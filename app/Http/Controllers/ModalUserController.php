<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ModalUserController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    
        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'password' => 'nullable|min:6'
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->password) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->back()->with('success', 'User updated successfully!');
}
public function destroy($id)
{
    User::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'User deleted successfully!');
}

}
