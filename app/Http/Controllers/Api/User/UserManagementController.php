<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    //Hiển thị all user
    public function index() {
        $users = User::paginate(8);
        return view('pages.user-management', compact('users'));
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('components.edit-user', compact('user'));
    }

    public function store(Request $request) {
        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->date_of_birth = $request->date_of_birth;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;

        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->date_of_birth = $request->date_of_birth;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id) {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function search(Request $request) {
        $keyword = $request->input('keyword');
        $users = User::where('fullname', 'like', "%$keyword%")
                ->orWhere('username', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%")
                ->get();
        return response()->json($users);
    }
}
