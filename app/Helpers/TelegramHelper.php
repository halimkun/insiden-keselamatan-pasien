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
    public static function sendMessage(string $status, string $action, array $data)
    {
        $message = self::generateMessage($status, $action, $data);

        $mandatory = [
            'chat_id'       => env('TELEGRAM_CHAT_ID'),
            'parse_mode'    => 'MarkdownV2',
        ];

        if (env('TELEGRAM_THREAD_ID') && env('TELEGRAM_THREAD_ID') != 0) {
            $mandatory['message_thread_id'] = env('TELEGRAM_THREAD_ID');
        }

        Telegram::sendMessage(array_merge($mandatory, ['text' => $message]));
    }

    /**
     * Generate the message content based on status, action, and data.
     * 
     * @param string $status
     * @param string $action
     * @param array $data
     * @return string
     */
    private static function generateMessage(string $status, string $action, array $data): string
    {
        $formattedData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        return
            "*$status  $action*\n\n" .
            "*Action by:* `" . addslashes(auth()->user()->name ?? 'System') . "`\n" .
            "*Action on:* `" . addslashes(now()->locale('id')->isoFormat('dddd, D MMM YYYY HH:mm:ss')) . "`\n\n" .
            "```\n" .
                $formattedData .
            "\n```";
    }
}
