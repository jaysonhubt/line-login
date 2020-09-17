<?php

namespace App\Helpers;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class LineHelper extends LINEBot
{
    public function __construct(array $args = [])
    {
        $httpClient = new CurlHTTPClient(env('CHANNEL_TOKEN'));
        parent::__construct($httpClient, [...$args, ['channelSecret' => env('CHANNEL_SECRET')]]);
    }
}
