<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    private function ensureAdmin(): void
    {
        $user = auth()->user();

        abort_unless($user && $user->is_admin, 403);
    }

    public function index(): View
    {
        $this->ensureAdmin();

        $users = User::query()
            ->select(['id', 'name', 'phone', 'created_at'])
            ->where('is_admin', false)
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user): View
    {
        $this->ensureAdmin();

        abort_if($user->is_admin, 403);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->ensureAdmin();

        abort_if($user->is_admin, 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Nama user berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->ensureAdmin();

        abort_if($user->is_admin, 403);

        DB::transaction(function () use ($user) {
            DB::table('document_reminder_logs')
                ->where('user_id', $user->id)
                ->delete();

            Document::query()
                ->where('user_id', $user->id)
                ->delete();

            $user->delete();
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
