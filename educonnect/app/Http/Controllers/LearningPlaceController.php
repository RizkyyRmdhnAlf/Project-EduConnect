<?php

namespace App\Http\Controllers;

use App\Models\LearningPlace;
use Illuminate\Support\Str;

class LearningPlaceController extends Controller
{
    public function index()
    {
        $learningPlaces = LearningPlace::latest()
            ->get()
            ->map(function ($place) {
                return [
                    'title' => $place->name,
                    'slug' => Str::slug($place->name),
                    'location' => $place->address,
                    'category' => $place->category,
                    'description' => $place->description,
                    'image' => $place->image
                        ? asset('storage/' . $place->image)
                        : null,
                    'facilities' => [],
                    'verification_status' => 'Belum Diverifikasi',
                    'is_free' => false,
                    'cost' => 'Belum ditentukan',
                ];
            });

        return view('learning-places.index', compact('learningPlaces'));
    }
}
