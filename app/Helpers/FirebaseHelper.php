<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FirebaseHelper
{
    public static function getAccessToken()
    {
        return Cache::remember('firebase_access_token', 3500, function () {
            $credentialsPath = storage_path('app/firebase/firebase-credentials.json');
            $credentials = json_decode(file_get_contents($credentialsPath), true);

            $now = time();
            $payload = [
                'iss' => $credentials['client_email'],
                'scope' => 'https://www.googleapis.com/auth/datastore',
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ];

            $jwtHeader = self::base64UrlEncode(json_encode([
                'alg' => 'RS256',
                'typ' => 'JWT',
            ]));

            $jwtPayload = self::base64UrlEncode(json_encode($payload));

            // Sign JWT
            $dataToSign = "$jwtHeader.$jwtPayload";
            $privateKey = $credentials['private_key'];
            openssl_sign($dataToSign, $signature, $privateKey, 'sha256WithRSAEncryption');
            $jwtSignature = self::base64UrlEncode($signature);

            $jwt = "$jwtHeader.$jwtPayload.$jwtSignature";

            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]);

            return $response->json()['access_token'];
        });
    }

    public static function getDocument($path)
    {
        $token = self::getAccessToken();

        $projectId = 'career-apps'; // Ganti sesuai project ID Firestore-mu
        $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/{$path}";

        $response = Http::withToken($token)->get($url);

        return $response->successful() ? $response->json() : null;
    }

    private static function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
