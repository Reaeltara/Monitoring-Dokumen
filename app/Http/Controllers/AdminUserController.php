<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        abort_unless($user && $user->is_admin, 403);

        $users = User::query()
            ->select(['id', 'name', 'phone', 'created_at'])
            ->where('is_admin', false)
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }
}
