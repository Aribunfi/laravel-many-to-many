<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index ()
{
    $projects = Project::all();
    return response()->json([
        'success' => true,
        'results' => $projects
    ]);
}
}

