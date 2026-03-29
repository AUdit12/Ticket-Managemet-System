<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{


    public function register(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        // Create the user
        DB::table('users')->insert([
            'name' => $request->name,
            'password' => $request->password,
        ]);

        // Respond with JSON for AJAX
        return response()->json([
            'success' => true,
            'redirect' => url('/') 
        ]);

         return response()->json([
                'success' => false
        ], 401);
    }





    public function login(Request $request)
    {
        // dd("hello");

        $request->validate([
            'name' => 'required|string',
            'password' => 'required'
        ]);

        $user = DB::table('users')->where('name', $request->name)->first();

        if ($user && $request->password == $user->password) {

            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('role', $user->role);

            return response()->json([
                'success' => true,
                'redirect' => '/dashboard'
            ]);
        }

            return response()->json([
                'success' => false
            ], 401);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'discription' => 'required',
            'priority' => 'required'
        ]);

        DB::table('tickets')->insert([
            'title' => $request->title,
            'discription' => $request->discription,
            'status' => $request->status,
            'priority' => $request->priority,
            'create_at' =>  now(),
        ]);

        return response()->json([
            'success' => true,
            'redirect' => '/dashboard'
        ]);
        
    }

    public function ticketView()
    {
        $tickets = DB::table('tickets')->get();

        return view('view_tickets', compact('tickets'));
    }

    public function userView()
    {
        $users = DB::table('users')->get();

        return view('view_users', compact('users'));
    }

    public function delete($id)
    {
        DB::table('tickets')->where('id', $id)->delete();

        return response()->json([
            'success' => true
        ]);
    
    }

    public function edit($id)
    {
        $ticket = DB::table('tickets')->where('id', $id)->first();

        return view('edit_ticket', compact('ticket'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'discription' => 'required',
            'status' => 'required'
        ]);

        DB::table('tickets')->where('id', $id)->update([
            'title' => $request->title,
            'discription' => $request->discription,
            'status' => $request->status,
            'priority' => $request->priority,
            'updated_at' => now()
        ]);

        return redirect('/tickets-view')->with('success', 'Ticket Updated');
    }

    public function ticketCounts()
    {
        $total = DB::table('tickets')->count();
        $open = DB::table('tickets')->where('status', 'Open')->count();
        $inProgress = DB::table('tickets')->where('status', 'In Progress')->count();
        $closed = DB::table('tickets')->where('status', 'Closed')->count();

        $low = DB::table('tickets')->where('priority', 'Low')->count();
        $medium = DB::table('tickets')->where('priority', 'Medium')->count();
        $high = DB::table('tickets')->where('priority', 'High')->count();


        return view('dashbord', compact('total', 'open', 'inProgress', 'closed', 'low', 'medium', 'high'));
    }

    public function logout()
    {
        Session::flush(); 
        return redirect('/'); 
    }

}