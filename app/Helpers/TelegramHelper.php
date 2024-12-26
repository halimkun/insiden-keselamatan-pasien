<?php

namespace App\Helpers;

use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramHelper
{
    /**
     * Send a message to the Telegram channel.
     * 
     * @param string $status
     * @param string $action
     * @param array $data
     * @param string $chatId
     */
    public static function sendMessage(string $status, string $action, array $data, array $notes = []): void
    {
        $message = self::generateMessage($status, $action, $data, $notes);

        $mandatory = [
            'chat_id'       => env('TELEGRAM_CHAT_ID'),
            'parse_mode'    => 'MarkdownV2',
        ];

        if (env('TELEGRAM_THREAD_ID') && env('TELEGRAM_THREAD_ID') != 0) {
            $mandatory['message_thread_id'] = env('TELEGRAM_THREAD_ID');
        }

        try {
            self::writeMessageToLog('info', $action, [
                'status' => $status,
                'data'   => $data,
                'notes'  => $notes,
            ]);
            
            Telegram::sendMessage(array_merge($mandatory, ['text' => $message]));
        } catch (\Throwable $th) {
            self::writeMessageToLog('warning', 'TELEGRAM LOG -- FAILED TO SEND MESSAGE', [
                'status' => $status,
                'action' => $action,
                'data'   => $data,
                'notes'  => $notes,
                'error'  => $th->getMessage(),
            ]);
        }
    }

    /**
     * Generate the message content based on status, action, and data.
     * 
     * @param string $status
     * @param string $action
     * @param array $data
     * @return string
     */
    private static function generateMessage(string $status, string $action, array $data, array $notes): string
    {
        $formattedData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $text = "*$status  $action*\n\n";
        $text .= "*Action by:* `" . addslashes(auth()->user()->name ?? 'System') . "`\n";
        $text .= "*Action on:* `" . addslashes(now()->locale('id')->isoFormat('dddd, D MMM YYYY HH:mm:ss')) . "`\n\n";
        $text .= "```\n";
        $text .=    $formattedData;
        $text .= "\n```";
        $text .= "\n";
        
        if (count($notes) > 0) {
            $text .= "**> *Notes:*\n";
            foreach ($notes as $key => $value) {
                $text .= "> • $value\n";
            }
        }

        return $text;
    }

    private static function writeMessageToLog(string $level, string $action, array $data): void
    {
        \Illuminate\Support\Facades\Log::channel('ikp')->log($level, $action, $data);
    }
}
