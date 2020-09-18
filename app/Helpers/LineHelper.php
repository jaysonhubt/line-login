<?php

namespace App\Helpers;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder;

class LineHelper extends LINEBot
{
    public MessageBuilder $messageBuilder;

    public function __construct(MessageBuilder $messageBuilder, array $args = [])
    {
        $this->messageBuilder = $messageBuilder;
        $httpClient = new CurlHTTPClient(env('CHANNEL_TOKEN'));
        parent::__construct($httpClient, [...$args, 'channelSecret' => env('CHANNEL_SECRET')]);
    }
}
