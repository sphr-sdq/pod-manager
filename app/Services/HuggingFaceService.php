<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class HuggingFaceService
{
    private string $apiUrl = 'https://black-forest-labs-flux-1-dev.hf.space/gradio_api/call/infer';

    public function generateImage(string $prompt): ?string
    {
        try {
            $client = new Client();
            $response = $client->post($this->apiUrl, [
                'json' => [
                    'data' => [
                        $prompt, 0, true, 256, 256, 1, 1
                    ]
                ],
                'headers' => ['Content-Type' => 'application/json']
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Failed to initiate image generation');
            }

            ds($response->getBody());

            $eventId = json_decode($response->getBody(), true)['data'][0];

            $imageResponse = $client->get($this->apiUrl.$eventId);

            ds($imageResponse);

            if ($imageResponse->getStatusCode()  === 200) {
                return json_decode($imageResponse->getBody(), true)['data'][0];
            }


            throw new \Exception('Image generation timed out');


        } catch (GuzzleException $e) {
            \Log::error('Image generation failed from : ' . $e->getMessage());
            return null;
        }
    }

    public function saveImageToStorage(string $base64Image, string $userId): string
    {
        $image = base64_decode($base64Image);
        $filename = 'profile-' . $userId . '-' . Str::random(10) . '.png';
        $path = 'public/profile-pictures/' . $filename;

        Storage::put($path, $image);
        ds($filename);
        return $filename;
    }
}
