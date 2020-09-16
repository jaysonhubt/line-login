<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LineController extends Controller
{
    const AUTHOR_REQUEST_URL = 'https://access.line.me/oauth2/v2.1/authorize';
    const RESPONSE_TYPE = 'code';
    const CLIENT_ID = 1654923778;
    const STATE = 'random_string';
    const SCOPE = 'profile%20openid%20email';
    const CLIENT_SECRET = '04f226eb9eae8a57cdcb9fe361c52047';

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
        Log::channel('single')->info($request->all());
        dd($request->all());
    }
}
