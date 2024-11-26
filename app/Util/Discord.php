<?php

namespace App\Util;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Discord
{
    const WEBHOOK = env("DISCORD_WEBHOOK");

    public static function logResponse(Response $response, string $message)
    {
        if(self::WEBHOOK !== null){
            $statusCode = $response->status();
            $content = $response->getBody()->getContents();
            $content = self::cutOverlengtMessageToDiscord($content);
            Http::post(self::WEBHOOK, [
                'content' => <<<MS
                Message: $message
                Status Code : $statusCode
                Message: $content
                MS
            ]);
        }
    }

    public static function send($content)
    {
        if(self::WEBHOOK !== null){
            Http::post(self::WEBHOOK, [
                'content' => $content
            ]);
        }
    }

    private static function cutOverlengtMessageToDiscord(string $message): string
    {
        $strMessage = str($message);
        return ($strMessage->length() < 1800) ? $message : $strMessage->substr(0, 1800)->toString();
    }
}
