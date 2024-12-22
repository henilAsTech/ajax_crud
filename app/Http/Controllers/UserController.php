<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(Request $request)
    {
        $query = $request->get('search');
        $users = $this->userService->get($query);
        if ($request->ajax()) {
            return view('partials.list', compact('users', 'query'))->render();
        }
        return view('user.list', compact('users'));
    }

    public function create(Request $request)
    {
        $user = new User();
        if ($request->ajax()) {
            return view('partials.create', compact('user'))->render();
        }
        return view('user.create');
    }

    public function store(UserRequest $request)
    {   
        if ($request->user_id) {
            $this->update($request->all());
        }
        $this->userService->create($request->validated());
        return response()->json(['status' => 'success', 'message' => 'User added successfully.']);
    }

    public function edit(Request $request, User $user) 
    {
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'user' => $user,
                'html' => view('partials.create', compact('user'))->render()
            ]);
        }
        return view('user.create', compact('user'));
    }

    public function update($request)
    {
        $this->userService->update($request);
        return response()->json(['status' => 'success', 'message' => 'User update successfully.']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => 'success', 'message' => 'User deleted successfully.']);
    }
}
