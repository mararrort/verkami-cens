<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use App\Models\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function setUpdate(Request $request)
    {
        Log::info('There has been an update from Telegram', ['update' => $request->all()]);
        $update = new Update(json_decode(json_encode($request->all()), false));
        $response = response('Ok', 200);

        // Check if the update has already been processed
        if (DB::table('telegram')->where('id', $update->getId())->doesntExist()) {
            // Check if it is a bot command
            if ($update->isBotCommand()) {
                $chatId = $update->getChatId();
                $telegramUser = TelegramUser::firstOrCreate(['id' => $chatId]);
                $telegramUser->id = $chatId;
                if ($update->isStartRequest()) {
                    Log::info('Is start petition');
                    $telegramUser->setAcceptedPetitions(true);
                    // Notify the user
                    $response = response()->json([
                        'method' => 'sendMessage',
                        'chat_id' => $chatId,
                        'text' => 'A partir de ahora enviaré notificaciones a este chat',
                    ]);
                }
                if ($update->isStopRequest()) {
                    Log::info('Is stop petition');
                    $telegramUser->setAcceptedPetitions(false);
                    $response = response()->json([
                        'method' => 'sendMessage',
                        'chat_id' => $chatId,
                        'text' => 'A partir de ahora no enviaré notificaciones a este chat',
                    ]);
                }
                if ($update->isStartPetitionsRequest()) {
                    Log::info('Is start petitions petition');
                    $telegramUser->setCreatedPetitions(true);
                    $response = response()->json([
                        'method' => 'sendMessage',
                        'chat_id' => $chatId,
                        'text' => 'A partir de ahora enviaré notificaciones sobre las peticiones creadas a este chat',
                    ]);
                }
                if ($update->isStopPetitionsRequest()) {
                    Log::info('Is stop petitions petition');
                    $telegramUser->setCreatedPetitions(false);
                    $response = response()->json([
                        'method' => 'sendMessage',
                        'chat_id' => $chatId,
                        'text' => 'A partir de ahora no enviaré notificaciones sobre las peticiones creadas a este chat',
                    ]);
                }
                // Remove the User if they do not want any update, persist either way.
                if (! $telegramUser->isAcceptedPetitions() && ! $telegramUser->isCreatedPetitions()) {
                    $telegramUser->delete();
                } else {
                    $telegramUser->save();
                }
            }
        } else {
            Log::info('Duplicated update, has been ignored');
        }

        return $response;
    }
}
