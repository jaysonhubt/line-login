<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class LineController extends Controller
{
    const AUTHOR_REQUEST_URL = 'https://access.line.me/oauth2/v2.1/authorize';
    const RESPONSE_TYPE = 'code';
    const CLIENT_ID = 1654923778;
    const STATE = 'random_string';
    const SCOPE = 'profile%20openid%20email';
    const CLIENT_SECRET = '04f226eb9eae8a57cdcb9fe361c52047';
    const CHANNEL_TOKEN = '9HtT9mHDETFdiWrXX8xTmjauaOMiHDI4IaavUBX59ftcLtkuo64C3TI1g43OxY8Ksq+yBDl5ZeNIfOxlnmSFy6VYubNLTvKxMjQxwVTV1zZiRQUyrmpUmJTjUsXwrjqx02YjHTrZh/AqAE0xK5U6LgdB04t89/1O/w1cDnyilFU=';
    const CHANNEL_SECRET = 'ec46fc50e1dbfa160360eae8767d8831';

    private $httpClient;
    private $bot;

//    public function __construct(
//        CurlHTTPClient $httpClient,
//        LINEBot $bot
//    ) {
//        $this->httpClient = $httpClient;
//        $this->bot = $bot;
//    }

    public function lineLogin() {
        $url = self::AUTHOR_REQUEST_URL .
            '?response_type=' . self::RESPONSE_TYPE .
            '&client_id=' . self::CLIENT_ID .
            '&redirect_uri=' . route('line_verify') .
            '&state=' . self::STATE .
            '&scope=' . self::SCOPE;

        return redirect($url);
    }

    public function verify(Request $request) {
        $this->httpClient = new CurlHTTPClient(self::CHANNEL_TOKEN);
        $this->bot = new LINEBot($this->httpClient, ['channelSecret' => self::CHANNEL_SECRET]);
        dd( $this->httpClient,  $this->bot);

        $code = $request->code;
        return view('verify', compact('code'));
    }

    public function getAccessToken(Request $request) {
        $response = HTTP::asForm()
            ->post('https://api.line.me/oauth2/v2.1/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => route('line_verify'),
            'client_id' => self::CLIENT_ID,
            'client_secret' => self::CLIENT_SECRET
        ]);

        if ($response->failed()) {
            $response->throw()->json();
        }

        dd($response->json());
    }

    public function result(Request $request) {
        dd($request->all());
    }

    public function webhook(Request $request) {
        Log::channel('single')->info('webhook');
        Log::channel('single')->info($request->all());

        if ($request['events'][0]['type'] === 'message') {
            $result = $this->sendDefaultReplyMessage($request['events'][0]['replyToken']);
            Log::channel('single')->info($result->json());
        }

        dd($request->all());
    }

    private function sendDefaultReplyMessage($replyToken) {
        $replyContent = [
            'replyToken' => $replyToken,
            'messages' => [
                [
                    'type' => 'text',
                    'text' => 'Hi!'
                ],
                [
                    'type' => 'sticker',
                    'packageId' => 11537,
                    'stickerId' => 52002736
                ],
                [
                    'type' => 'image',
                    'originalContentUrl' => 'https://picsum.photos/536/354',
                    'previewImageUrl' => 'https://picsum.photos/536/354'
                ]
            ],
            'notificationDisabled' => false
        ];

        Log::channel('single')->info($replyContent);

        return HTTP::withToken(self::CHANNEL_TOKEN)
            ->post('https://api.line.me/v2/bot/message/reply', $replyContent);
    }
}
