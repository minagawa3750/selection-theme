<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;

class TodolistController extends Controller
{
  public function index(Request $request)
  {
    $todolists = Todolist::all();
   
    return view('todolist.index', ['todolists' => $todolists]);
  }
}
