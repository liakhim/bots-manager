<?php

namespace App\Http\Controllers;

use App\Services\TelegramService;
use Illuminate\Http\Request;

class BotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function webhookHandler(Request $request)
    {
        $data = json_encode($request->all());

        $telegram = new TelegramService();
        $response = $telegram->sendMessage(
            env('TELEGRAM_LOGS_CHAT_ID'),
            $data
        );

        if ($response) {
            return response()->json(['status' => 'ok' ]);
        }

        return response()->json(['status' => 'error' ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
