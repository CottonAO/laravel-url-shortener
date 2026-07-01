<?php

namespace App\Services;

use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Str;

class ShortLinkService
{
    public function create(User $user, string $originalUrl): Link
    {
        return Link::create([
            'user_id' => $user->id,
            'original_url' => $originalUrl,
            'short_code' => $this->generateUniqueCode(),
        ]);
    }

    private function generateUniqueCode(int $length = 6): string
    {
        do {
            $code = Str::lower(Str::random($length));
        } while (Link::where('short_code', $code)->exists());

        return $code;
    }
}
