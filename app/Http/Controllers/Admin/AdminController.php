<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.show_pending_users',[
            'users' => User::where('status', 'pending')->get(),
        ]);
    }
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->approved_by = auth()->user()->id; // Set the ID of the approving administrator
        $user->save();

        return redirect()->back()->with('success', 'The user has been approved.');
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'The user has been deleted.');
    }
}
