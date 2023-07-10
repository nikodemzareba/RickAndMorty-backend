<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class BackendSideController extends Controller
{
    public function getRickAndMortyData(Request $request)
    {
        $client = new Client();

        // retrieve the filter parameters from the request
        $query = [
            'name' => $request->get('name'),
            'species' => $request->get('species'),
            'origin' => $request->get('origin'),
            'page' => $request->get('page'),
        ];

        // create a cache key unique to this query
        $cacheKey = 'rickandmorty.characters.' . md5(serialize($query));

        $data = Cache::remember($cacheKey, 60, function () use ($client, $query) {
            $res = $client->request('GET', 'https://rickandmortyapi.com/api/character/', [
                'query' => $query
            ]);
            return json_decode($res->getBody(), true);
        });

        return response()->json($data['results']);
    }
}
