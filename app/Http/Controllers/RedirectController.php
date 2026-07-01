<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkClick;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke(Request $request, string $shortCode): RedirectResponse
    {
        $link = Link::where('short_code', $shortCode)->firstOrFail();

        LinkClick::create([
            'link_id' => $link->id,
            'ip_address' => $request->ip() ?? '0.0.0.0',
            'clicked_at' => now(),
        ]);

        return redirect()->away($link->original_url);
    }
}
