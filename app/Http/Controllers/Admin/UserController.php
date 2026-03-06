<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 1️⃣ List + search + filter
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->keyword}%")
                  ->orWhere('email', 'like', "%{$request->keyword}%");
            });
        }

        // Lọc role
        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->orderByDesc('created_at')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    // 2️⃣ Add form
    public function create()
    {
        return view('admin.users.create');
    }

    // 3️⃣ Lưu user mới
    public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'phone'    => ['nullable','regex:/^\+?[0-9\s\-]{9,15}$/'], // optional, hỗ trợ +84
        'password' => 'required|string|min:6',
        'role'     => 'required|in:user,admin',
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'phone'    => $request->phone,
        'role'     => $request->role,
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('admin.users.index')
        ->with('success', 'Account added successfully');
}



    // 4️⃣ View details
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // 5️⃣ Form sửa
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // 6️⃣ Cập nhật
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required|in:admin,user',
            'phone' => 'nullable|regex:/^[0-9]{9,11}$/', // validate phone
        ]);

        // add 'phone' here
        $user->update($request->only('name','email','role','phone'));

        return redirect()->route('admin.users.index')
            ->with('success', 'Update successful');
    }


    // 7️⃣ Xóa
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error','Cannot delete admin');
        }

        $user->delete();

        return back()->with('success','Deleted successfully');
    }
}
