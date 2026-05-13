<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Admin no puede cambiar su propio rol
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                             ->with('error', 'No puedes cambiar tu propio rol.');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        $user->update($validated);

        return redirect()->route('users.index')
                         ->with('success', "Rol de {$user->name} actualizado correctamente.");
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                             ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Usuario eliminado correctamente.');
    }
}