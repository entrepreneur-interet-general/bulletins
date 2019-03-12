<?php

namespace App;

use wrapi\slack\slack as SlackLib;

class Slack
{

    public static function sendMessage($channel, $text)
    {
        $slack = new SlackLib(config('services.slack.token'));
        $slack->chat->postMessage(compact('channel', 'text'));
    }
}
