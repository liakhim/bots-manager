<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
//use App\Models\Channel;
use App\Models\Project;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProjectsController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        $projects = $user->projects()->get();
        //$channels = $user->channels()->get();
        //$first_channel = Channel::find(1);
        return response()->json(
            [
                'user' => $user,
                'projects' => $projects,
                //'channels' => $channels,
                //'test_channel' => $first_channel->admin_bots()->get(),
                //'user_of_channel' => $first_channel->users()
            ]
        );
    }

    public function create(Request $request): JsonResponse
    {
        Project::create([
            'user_id' => '1',
            'channel_id' => '1',
            'design_theme' => '1',
        ]);
        return response()->json(1);
    }

    public function delete(Request $request, $project_id): JsonResponse
    {
        Project::where('id', $project_id)->first()->delete();
        return response()->json(1);
    }
}
