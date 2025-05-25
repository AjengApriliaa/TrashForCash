<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('Userdetail', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'alamat', 'coin']));
        return redirect()->route('admin.kelolauser')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin.kelolauser')->with('success', 'User berhasil dihapus!');
    }
}
