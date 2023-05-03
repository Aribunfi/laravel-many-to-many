<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectController;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index ()
{
    $projects = Project::paginate(5);
    return response()->json([
        'success' => true,
        'results' => $projects
    ]);

    
    
}};

axios.get (${this.baseURL/api/projects}) (
    params (
        page->postApiPage
        )
);