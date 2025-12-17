<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

abstract class BaseApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(
            config('services.career_api.base_url'),
            '/'
        );
    }

    protected function get(string $endpoint)
    {
        $token = Session::get('api_token');
        if (!$token) {
            return null;
        }

        return Http::withToken($token)
            ->acceptJson()
            ->get($this->baseUrl . $endpoint);
    }

    protected function post(string $endpoint, array $data = [])
    {
        $token = Session::get('api_token');
        if (!$token) {
            return null;
        }

        return Http::withToken($token)
            ->acceptJson()
            ->post($this->baseUrl . $endpoint, $data);
    }
}
