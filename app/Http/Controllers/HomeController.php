<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function home()
    {
        return view('home');
    }

    public function cadastrarUser()
    {
        return view('create-user');
    }
    public function listarUsers()
    {
        $users = User::all();
        return view('list-users',[ 'users' => $users ] );
    }
}
