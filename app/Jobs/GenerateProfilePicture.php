<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\HuggingFaceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateProfilePicture implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(HuggingFaceService $huggingFaceService)
    {
        // Generate a random robot description for variety
        $prompt = $this->generateRobotPrompt();

        // Generate the image
        $base64Image = $huggingFaceService->generateImage($prompt);

        ds($base64Image);

        if ($base64Image) {
            // Save the image and update user profile
            $filename = $huggingFaceService->saveImageToStorage($base64Image, $this->user->id);

            $this->user->update([
                'profile_picture' => $filename
            ]);
        }
    }

    private function generateRobotPrompt(): string
    {
        $styles = ['futuristic', 'steampunk', 'minimalist', 'cute'];
        $colors = ['blue', 'silver', 'golden', 'white'];

        $style = $styles[array_rand($styles)];
        $color = $colors[array_rand($colors)];

        return "A {$style} {$color} robot avatar, digital art style";
    }
}
