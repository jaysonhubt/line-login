<?php

namespace App\Http\Controllers;

use App\Helpers\LineHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class LineController extends Controller
{
    const AUTHOR_REQUEST_URL = 'https://access.line.me/oauth2/v2.1/authorize';
    const RESPONSE_TYPE = 'code';
    const CLIENT_ID = 1654923778;
    const STATE = 'random_string';
    const SCOPE = 'profile%20openid%20email';
    const CLIENT_SECRET = '04f226eb9eae8a57cdcb9fe361c52047';

    private LineHelper $lineHelper;

    public function __construct(LineHelper $lineHelper)
    {
        $this->lineHelper = $lineHelper;
    }

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
        $code = $request->code;
        $data = $request->toArray();
        return view('verify', compact(['code', 'data']));
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

    public function webhook(Request $request) {
        Log::channel('single')->info('webhook');
        Log::channel('single')->info($request->all());

        if ($request['events'][0]['type'] === 'message') {
            $result = $this->lineHelper->replyText($request['events'][0]['replyToken'], 'From LINEBot with love!');
            if (!$result->isSucceeded()) {
                Log::channel('single')->info($result->getHTTPStatus() . ' ' . $result->getRawBody());
            }

            $groupId = 'C13c5e5724af770ec2acd48470b1ccd83';
            $message = new TextMessageBuilder('This is Push Message to Test GR');
            $pushMessageGr = $this->lineHelper->pushMessage($groupId, $message);
            if (!$pushMessageGr->isSucceeded()) {
                Log::channel('single')->info('This is Push Message to Test GR' . $pushMessageGr->getHTTPStatus() . ' ' . $pushMessageGr->getRawBody());
            }

            $userId = 'Ud7a58ed5efb8a8f8eb845bf7e1b2c958';
            $user = $this->lineHelper->getProfile($userId);
            $message = new TextMessageBuilder('This is Push Message to ' . $user->getJSONDecodedBody()['displayName']);
            $pushMessageUser = $this->lineHelper->pushMessage($userId, $message);
            if (!$pushMessageUser->isSucceeded()) {
                Log::channel('single')->info('This is Push Message to ' . $user->getJSONDecodedBody()['displayName'] . $pushMessageUser->getHTTPStatus() . ' ' . $pushMessageUser->getRawBody());
            }

            $broadcastMessage = $this->lineHelper->broadcast(new TextMessageBuilder('This is Broadcast message from Son Tran\'s Bot'));
            if (!$broadcastMessage->isSucceeded()) {
                Log::channel('single')->info('Broadcast message:' . $broadcastMessage->getHTTPStatus() . ' ' . $broadcastMessage->getRawBody());
            }
        }
    }
}
