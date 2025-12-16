<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Mahasiswa
{
    protected static string $baseUrl = 'http://152.42.160.174:7000/api/student';

    public static function login($email, $password)
    {
        $response = Http::post(self::$baseUrl . '/signin', [
            'email' => $email,
            'password' => $password,
        ]);

        if ($response->successful()) {
            $token = $response->json('data.token');
            Session::put('api_token', $token);
            return $token;
        }

        return null;
    }

    public static function ambilProfil()
    {
        $token = Session::get('api_token'); 
        if (!$token) return null;

        $response = Http::withToken($token)->get(self::$baseUrl . '/detail');
        if ($response->successful()) {
            $profil = $response->json('data');
            Session::put('student_id', $profil['id']);
            Session::put('student_name', $profil['name']);
            Session::put('student_nim', $profil['nim']);
            Session::put('student_photo', $profil['fotoProfil']);
            return $profil;
        }

        return null;
    }

    public static function ambilRekomendasiKarier()
    {
        $token = Session::get('api_token');
        if (!$token) return null;

        $response = Http::withToken($token)->get(self::$baseUrl . '/career');
        $data = collect($response->json('data') ?? []);
        return $data->first()['careerPrediction'] ?? null;
    }
}
