<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // POST /api/users
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname'       => 'required|string|max:50',
            'date_of_birth'  => 'nullable|date',
            'phone'          => 'nullable|string|size:10',
            'email'          => 'required|email|unique:users',
            'username'       => 'required|string|max:50|unique:users',
            'password'       => 'required|string|min:6',
            'avatar'         => 'nullable|string|max:135',
            'role'           => 'in:admin,customer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'fullname'      => $request->fullname,
            'date_of_birth' => $request->date_of_birth,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'avatar'        => $request->avatar,
            'role'          => $request->role ?? 'customer',
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user'    => $user
        ], 201);
    }

    // GET /api/users/{id}
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return view('pages.profile', compact('user'));
    }

    // PUT/PATCH /api/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'fullname'       => 'nullable|string|max:50',
            'date_of_birth'  => 'nullable|date',
            'phone'          => 'nullable|string|size:10',
            'email'          => 'nullable|email|unique:users,email,' . $id,
            'username'       => 'nullable|string|max:50|unique:users,username,' . $id,
            'password'       => 'nullable|string|min:6',
            'avatar'         => 'nullable|string|max:135',
            'role'           => 'nullable|in:admin,customer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Cập nhật dữ liệu
        $user->fill([
            'fullname'      => $request->fullname ?? $user->fullname,
            'date_of_birth' => $request->date_of_birth ?? $user->date_of_birth,
            'phone'         => $request->phone ?? $user->phone,
            'email'         => $request->email ?? $user->email,
            'username'      => $request->username ?? $user->username,
            'avatar'        => $request->avatar ?? $user->avatar,
            'role'          => $request->role ?? $user->role,
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user'    => $user
        ]);
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
