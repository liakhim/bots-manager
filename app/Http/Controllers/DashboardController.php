<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): Response
    {
        $user = \auth()->user();
        $user_projects = $user->projects()->get();
        return Inertia::render('Dashboard/Index', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'user_projects' => $user_projects
        ]);
    }

    /**
     * Create project.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Dashboard/CreateProject');
    }

    public function createProject(Request $request): Response
    {
        $user = \auth()->user();
        Project::create([
            'user_id' => $user["id"]
        ]);

        $user_projects = $user->projects()->get();

        return Inertia::render('Dashboard/Index', [
            'user_projects' => $user_projects
        ]);
    }

    /**
     * Show project.
     */
    public function show(Request $request, $id): Response
    {
        // $request->user()->fill($request->validated());

        $user = User::find($id);

        return Inertia::render('Dashboard/Project', [
            'project' => $user
        ]);
    }
}
