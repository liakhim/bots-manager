<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class YandexMusicController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://music.yandex.ru/handlers/']);
    }

    public function searchArtist($artistName)
    {
        $response = $this->client->get('music-search.jsx', [
            'query' => [
                'text' => $artistName,
                'type' => 'artists',
                'ncrnd' => microtime(true)
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        if (isset($data['artists']['items'][0])) {
            return $data['artists']['items'][0]['id'];
        }

        return null;
    }

    public function getArtistTracks($artistId)
    {
        $response = $this->client->get('artist.jsx', [
            'query' => [
                'artist' => $artistId,
                'what' => 'tracks',
                'ncrnd' => microtime(true) // Использование текущего времени в микросекундах как случайного числа
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        return $data['tracks'] ?? null;
    }

    public function getTracks(Request $request, $artistName)
    {
        $artistId = $this->searchArtist($artistName);

        if (!$artistId) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $tracks = $this->getArtistTracks($artistId);

        if (!$tracks) {
            return response()->json(['message' => 'Tracks not found'], 404);
        }

        return response()->json($tracks);
    }
}
