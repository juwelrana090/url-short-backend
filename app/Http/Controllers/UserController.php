<?php

namespace App\Mail;
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.list', [
            'users' => $users,
        ]);
    }


    public function add()
    {
        return view('users.add');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'full_name' => ['required'],
            'phone' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
            'role' => ['required'],
        ]);

        $nowdate = date('d, F, Y g:i A');

        $user = User::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'date_at' => $nowdate,
        ]);

        return Redirect::route('user.index')->with('success', 'User registion successfuly...');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', "=", $id)->first();

        return view('users.update', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'full_name' => ['required'],
            'phone' => ['required'],
            'email' => ['required'],
            'username' => ['required'],
            'role' => ['required'],
        ]);


        $user = User::where('id', $request->id)->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return Redirect::route('user.edit', $request->id)->with('success', 'User update successfuly...');

    }

    public function pchange(Request $request, User $user)
    {
        $this->validate($request, [
            'password' => ['required'],
        ]);

        $user = User::where('id', $request->id)->update([
            'password' => bcrypt($request->password),
        ]);

        return Redirect::route('user.edit', $request->id)->with('success', 'User password update successfuly...');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user)
    {
        if ($user) {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User delete successfuly...');
        } else {
            return redirect()->route('user.index')->with('error', 'User not delete');
        }
    }
}
