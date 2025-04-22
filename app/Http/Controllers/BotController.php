<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserUpdates;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function webhookHandler(Request $request)
    {
        $data = json_encode($request->all());

        $keyboard = [[
            [
                'text' => 'Landing',
                'web_app' => [
                    'url' => 'https://bots-manager.ru?token=qddderfwsasdedec' // замените на свою ссылку
                ]
            ]
        ]];

        $reply_markup = json_encode([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        Log::info('----------');
        Log::info(json_encode($request->all()));

        if ($request->all()["message"]["text"] == "/about") {
            $user = User::where('chat_id', $request->all()["message"]["chat"]["id"])->first();
            if (!$user) {
                User::create([
                    'name' => $request->all()["message"]["chat"]["first_name"],
                    'tg_username' => $request->all()["message"]["chat"]["username"],
                    'is_bot' => $request->all()["message"]["from"]["is_bot"],
                    'language_code' => $request->all()["message"]["chat"]["language_code"],
                    'is_premium' => $request->all()["message"]["from"]["is_premium"],
                    'chat_id' => $request->all()["message"]["chat"]["id"],
                ]);
            }

            $data = 'Нажми на кнопку "О нас" чтобы открыть страницу с информацией';

            $telegram = new TelegramService('7702828915:AAFXDdjc4urnXR1LdYVLLyhEP7t3GvXf3Lw', env('TELEGRAM_LOGS_CHAT_ID'));
            $response = $telegram->sendMessage($data, $reply_markup);
        } else {
            UserUpdates::create([

            ]);
            $telegram = new TelegramService(env('TELEGRAM_LOGS_BOT_TOKEN'), env('TELEGRAM_LOGS_CHAT_ID'));
            $response = $telegram->sendMessage($data);
        }

        if ($response) {
            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'error']);
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
