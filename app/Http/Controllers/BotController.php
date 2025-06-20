<?php

namespace App\Http\Controllers;

use App\Models\DTO\User\UserCreateDto;
use App\Models\DTO\User\UserUpdateObjCreateDto;
use App\Models\User;
use App\Services\TelegramService;
use App\Services\UserCreateService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function webhookHandler(Request $request): JsonResponse
    {
        $data = json_encode($request->all());
        $data_to_code = "```json\n" . json_encode($request->all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)  . "\n```";
        $chatId = Arr::get($request->all(), 'message.chat.id');
        /* @var User $user */
        $user = User::firstOrNew(['chat_id' => $chatId]);
        if (!$user) {
            $userData = new UserCreateDto(
                name: Arr::get($request->all(), 'message.chat.first_name'),
                tg_username: Arr::get($request->all(), 'message.chat.username'),
                is_bot: Arr::get($request->all(), 'message.from.is_bot', false),
                language_code: Arr::get($request->all(), 'message.from.language_code'),
                is_premium: Arr::get($request->all(), 'message.from.is_premium', false),
                chat_id: $chatId
            );
            $userUpdateData = new UserUpdateObjCreateDto(
                user_id: $user->user_id,
                update_id: Arr::get($request->all(), 'message.update_id'),
                data: Arr::get($request->all(), 'message'),
                data_type: Arr::get($request->all(), 'message.photo') ? 'photo' : 'text',
                date: Arr::get($request->all(), 'message.date'),
            );
            $user = (new UserCreateService($userData, $userUpdateData))->run();
        }

        Log::info('$user in BotController');
        Log::info($user);

        $keyboard = [[
            [
                'text' => 'Что умеет этот бот?',
                'web_app' => [
                    'url' => 'https://bots-manager.ru/about'
                ]
            ]
        ]];

        $reply_markup = json_encode([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        if (array_key_exists('text', $request->all()["message"]) && $request->all()["message"]["text"] === "/about") {

            $data = 'Нажми на кнопку "О нас" чтобы открыть страницу с информацией';

            $telegram = new TelegramService('7702828915:AAFXDdjc4urnXR1LdYVLLyhEP7t3GvXf3Lw', env('TELEGRAM_LOGS_CHAT_ID'));
            $response = $telegram->sendMessageAsCode($data, $reply_markup);
        } else {
            $telegram = new TelegramService(env('TELEGRAM_LOGS_BOT_TOKEN'), env('TELEGRAM_LOGS_CHAT_ID'));
            $response = $telegram->sendMessageAsCode($data_to_code);
        }

        if ($response) {
            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'error']);
    }

    public function everyDayWebhookHandler(Request $request): JsonResponse
    {
        $data = $request->all();
        $data_to_code = "```json\n" . json_encode($request->all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)  . "\n```";

        $telegram = new TelegramService(env('TELEGRAM_EVERY_DAY_BOT'), env('TELEGRAM_EVERY_DAY_CHAT_ID'));

        if (key_exists('callback_query', $data) && $data['callback_query']['data'] === 'now') {
            $response = $telegram->sendMessageAsCode(Carbon::now()->format('F d H:i'));
        } else if (key_exists('callback_query', $data) && $data['callback_query']['data'] === 'delay') {
            $keyboard = [[
                [
                    'text' => 'Нужно ввести время прихода',
                    "callback_data" => "entering",
                ]
            ]];

            $reply_markup = json_encode([
                'inline_keyboard' => $keyboard,
            ]);

            $response = $telegram->sendMessage('test', $reply_markup);

        } else {
            $response = $telegram->sendMessageAsCode($data_to_code);
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
