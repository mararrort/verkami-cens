<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Update;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TelegramController extends Controller
{
    public function setUpdate(Request $request)
    {
        Log::info("There has been an update from Telegram", ['update' => $request->all()]);
        $update = new Update(json_decode(json_encode($request->all()), false));
        $response = response("Ok", 200);

        // Check if the update has already been processed
        if (DB::table('telegram')->where('id', $update->getId())->doesntExist()) {
            // Check if it is a start request
            if ($update->isStartRequest()) {
                Log::info("The update is a start request");
                $chatId = $update->getChatId();
                // Check if it is already in the DDBB
                if (DB::table('telegram_chat')->where('id', $chatId)->doesntExist()) {
                    DB::table('telegram_chat')->insert(['id' => $chatId]);
                    Log::info("A chat has been added to the DDBB", ['chat' => $chatId]);

                    // Notify the user
                    $response = response()->json([
                        'method' => 'sendMessage',
                        'chat_id' => $chatId,
                        'text' => "A partir de ahora enviaré notificaciones a este chat",
                    ]);

                }
            } elseif ($update->isStopRequest()) {
                $chatId = $update->getChatId();
                Log::info("The update is a stop request, the chat will be removed from the DDBB", ['chat' => $chatId]);
                DB::table('telegram_chat')->where('id', $chatId)->delete();

                // Notify the user
                $response = response()->json([
                    'method' => 'sendMessage',
                    'chat_id' => $chatId,
                    'text' => "A partir de ahora dejaré de enviar notificaciones a este chat",
                ]);
            }
            DB::table('telegram')->insert(['id' => $update->getId()]);
        } else {
            Log::info("Duplicated update, has been ignored");
        }
        
        return $response;
    }
}
