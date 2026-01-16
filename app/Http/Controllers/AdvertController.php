<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdvertController extends Controller
{
    public function index()
    {
        $adverts = Advert::orderBy('slot')->get();
        return view('dashboard.add_adverts', compact('adverts'));
    }

    public function manageAdverts()
    {
        $adverts = Advert::orderBy('slot')->get();
        return view('dashboard.manage_adverts', compact('adverts'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'slot'  => 'required|in:two_left,two_right,single',
            'type'  => 'required|in:image,video',
            'advert_media' => 'required|file|mimes:jpg,jpeg,png,mp4|max:10240',
            'link'  => 'nullable|url',
        ]);

        // ✅ Handle media upload
        if ($request->hasFile('advert_media')) {
            $file = $request->file('advert_media');

            // Sanitize filename using slot + timestamp
            $sanitizedSlot = Str::slug($request->slot, '_');
            $fileName = $sanitizedSlot . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Destination path
            $destination = public_path('images/adverts');

            // Ensure directory exists
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            // Move file
            $file->move($destination, $fileName);

            $mediaPath = 'images/adverts/' . $fileName;
        }

        Advert::updateOrCreate(
            ['slot' => $request->slot],
            [
                'type'       => $request->type,
                'media_path' => $mediaPath ?? null,
                'link'       => $request->link,
                'is_active'  => true,
            ]
        );

        return back()->with('success', 'Advert saved successfully.');
    }

    public function destroy(Advert $advert)
    {
        if (file_exists(public_path($advert->media_path))) {
            unlink(public_path($advert->media_path));
        }

        $advert->delete();

        return back()->with('success', 'Advert deleted.');
    }
}
