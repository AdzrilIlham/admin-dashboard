<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutMeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'profile_image' => $this->profile_image_url,
            'resume_file' => $this->resume_file_url,
            'social_links' => [
                'github' => $this->github_url,
                'linkedin' => $this->linkedin_url,
                'twitter' => $this->twitter_url,
                'instagram' => $this->instagram_url,
            ],
            'contact' => [
                'email' => $this->email,
                'phone' => $this->phone,
                'location' => $this->location,
            ],
            'years_of_experience' => $this->years_of_experience,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}