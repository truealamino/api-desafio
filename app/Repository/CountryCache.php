<?php

namespace App\Repository;

use App\Enums\ResponseEnum;
use Carbon\Carbon;

class Countries
{
    const CACHE_KEY = '_COUNTRIES';

    public function getItems($type, $term, $clientRequest)
    {
        $registerKey = $this->getCacheKey("index_type_{$type}");
        $key = "index_type_{$type}_term_{$term}";
        $cacheKey = $this->getCacheKey($key);

        return cache()->tags([$registerKey])->remember($cacheKey, Carbon::now()->addMinutes(300), function () use ($type, $term, $clientRequest) {
            $response = $clientRequest['client']->get("/rest/v2/{$type}{$term}{$clientRequest['queryFields']}", ['headers' => $clientRequest['headers']]);

            return json_decode($response->getBody()->getContents());
        });

    }

    public function showItem($term, $clientRequest)
    {
        $registerKey = $this->getCacheKey("show_term_{$term}_query_{$clientRequest['queryFields']}");
        $key = "show_term_{$term}_query_{$clientRequest['queryFields']}";
        $cacheKey = $this->getCacheKey($key);

        return cache()->tags([$registerKey])->remember($cacheKey, Carbon::now()->addMinutes(300), function () use ($term, $clientRequest) {
            $response = $clientRequest['client']->get("/rest/v2/alpha/{$term}{$clientRequest['queryFields']}", ['headers' => $clientRequest['headers']]);

            return json_decode($response->getBody()->getContents());
        });
    }

    public function getByRegion($region, $clientRequest)
    {
        $registerKey = $this->getCacheKey("region_term_{$region}");
        $key = "region_term_{$region}";
        $cacheKey = $this->getCacheKey($key);

        return cache()->tags([$registerKey])->remember($cacheKey, Carbon::now()->addMinutes(300), function () use ($region, $clientRequest) {
            $response = $clientRequest['client']->get("/rest/v2/region/{$region}{$clientRequest['queryFields']}", ['headers' => $clientRequest['headers']]);

            return json_decode($response->getBody()->getContents());
        });
    }

    // Return a string cache key
    public function getCacheKey($key)
    {
        $key = strtoupper($key);

        return self::CACHE_KEY . env('APP_ENV') . "_$key";
    }
}
