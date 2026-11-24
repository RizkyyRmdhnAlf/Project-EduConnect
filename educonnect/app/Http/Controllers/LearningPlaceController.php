<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportLocationRequest;
use App\Models\AuditLog;
use App\Models\Flag;
use App\Models\LearningLocation;
use App\Models\LearningPlace;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class LearningPlaceController extends Controller
{
    /**
     * Display the learning places directory page.
     */
    public function index(Request $request): View
    {
        $learningPlaces = $this->getCombinedPlaces();

        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:100'],
            'kota' => ['nullable', 'string', 'max:100'],
            'kabupaten' => ['nullable', 'string', 'max:100'],
            'harga' => ['nullable', 'in:gratis,berbayar'],
        ]);

        $keyword = trim((string) ($filters['q'] ?? ''));
        $locationFilter = trim((string) ($filters['lokasi'] ?? ''));
        $cityFilter = trim((string) ($filters['kota'] ?? ''));
        $districtFilter = trim((string) ($filters['kabupaten'] ?? ''));
        $priceFilter = $filters['harga'] ?? '';

        if ($keyword !== '') {
            $needle = Str::lower($keyword);
            $learningPlaces = $learningPlaces->filter(function (array $place) use ($needle): bool {
                $haystack = Str::lower(implode(' ', [
                    $place['title'],
                    $place['category'],
                    $place['location'],
                    $place['description'],
                    implode(' ', $place['facilities'] ?? []),
                ]));

                return str_contains($haystack, $needle);
            });
        }

        if ($locationFilter !== '') {
            $locationNeedle = Str::lower($locationFilter);
            $learningPlaces = $learningPlaces->filter(function (array $place) use ($locationNeedle): bool {
                $placeLocation = Str::lower(($place['city'] ?? '').' '.$place['location']);

                return str_contains($placeLocation, $locationNeedle);
            });
        }

        if ($cityFilter !== '') {
            $cityNeedle = Str::lower($cityFilter);
            $learningPlaces = $learningPlaces->filter(function (array $place) use ($cityNeedle): bool {
                $city = $place['city'] ?? '';
                if ($city === '') {
                    $city = $place['location'] ?? '';
                }

                return str_contains(Str::lower((string) $city), $cityNeedle);
            });
        }

        if ($districtFilter !== '') {
            $districtNeedle = Str::lower($districtFilter);
            $learningPlaces = $learningPlaces->filter(function (array $place) use ($districtNeedle): bool {
                $districtText = Str::lower(($place['location'] ?? '').' '.($place['address'] ?? ''));

                return str_contains($districtText, $districtNeedle);
            });
        }

        if ($priceFilter === 'gratis') {
            $learningPlaces = $learningPlaces->where('is_free', true);
        } elseif ($priceFilter === 'berbayar') {
            $learningPlaces = $learningPlaces->filter(function (array $place): bool {
                return ! ($place['is_free'] ?? true) && ($place['cost'] ?? null) !== 'Belum ditentukan';
            });
        }

        return view('learning-places.index', [
            'learningPlaces' => $learningPlaces->values(),
            'keyword' => $keyword,
            'locationFilter' => $locationFilter,
            'cityFilter' => $cityFilter,
            'districtFilter' => $districtFilter,
            'priceFilter' => $priceFilter,
        ]);
    }

    /**
     * Display the full detail page for a specific learning location.
     */
    public function show(string $slug): View|Response
    {
        $place = $this->findPlaceBySlug($slug);

        if ($place === null) {
            return response()->view('learning-places.not-found', [
                'slug' => $slug,
            ], 404);
        }

        $recommendations = $this->getCombinedPlaces()
            ->reject(fn (array $item): bool => $item['slug'] === $place['slug'])
            ->take(3)
            ->values();

        return view('learning-places.show', [
            'place' => $place,
            'recommendations' => $recommendations,
        ]);
    }

    /**
     * Store a content moderation report/flag for a learning location.
     */
    public function report(ReportLocationRequest $request, string $slug): RedirectResponse
    {
        $place = $this->findPlaceBySlug($slug);

        if ($place === null) {
            abort(404);
        }

        $validated = $request->validated();
        $user = $request->user();

        $flag = Flag::query()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'reporter_id' => $user?->id,
            'reporter_name' => $user?->display_name ?? ($validated['reporter_name'] ?: 'Pengunjung'),
            'learning_location_id' => $place['is_learning_location'] ? $place['id'] : null,
            'place_slug' => $place['slug'],
            'moderation_status' => 'Menunggu',
        ]);

        if ($user !== null) {
            try {
                AuditLog::query()->create([
                    'actor_id' => $user->id,
                    'action' => 'report_location',
                    'target_type' => 'flag',
                    'target_id' => $flag->id,
                ]);
            } catch (Throwable) {
                // Keep report flow succeeding even if audit log insert fails.
            }
        }

        return redirect()
            ->route('learning-places.show', $place['slug'])
            ->with('report_success', 'Laporan Anda telah dikirim dan akan ditinjau oleh tim moderator EduConnect.');
    }

    /**
     * Find a single learning place by slug from `learning_locations` or `learning_places`.
     *
     * @return array<string, mixed>|null
     */
    private function findPlaceBySlug(string $slug): ?array
    {
        try {
            if (Schema::hasTable('learning_locations')) {
                $location = LearningLocation::query()
                    ->with('owner')
                    ->where('slug', $slug)
                    ->first();

                if ($location !== null) {
                    return $this->mapLearningLocation($location);
                }
            }
        } catch (Throwable) {
            // Continue checking other sources.
        }

        try {
            if (Schema::hasTable('learning_places')) {
                $places = LearningPlace::query()->latest()->get();

                $matched = $places->first(
                    fn (LearningPlace $place): bool => Str::slug($place->name) === $slug || (string) $place->id === $slug
                );

                if ($matched !== null) {
                    return $this->mapLearningPlace($matched);
                }
            }
        } catch (Throwable) {
            // Continue.
        }

        return null;
    }

    /**
     * Combine records from `learning_places` and `learning_locations` without duplicate slugs.
     *
     * @return Collection<int, array<string, mixed>>
     */
    private function getCombinedPlaces(): Collection
    {
        $items = collect();

        try {
            if (Schema::hasTable('learning_places')) {
                $places = LearningPlace::query()->latest()->get();
                foreach ($places as $place) {
                    $items->push($this->mapLearningPlace($place));
                }
            }
        } catch (Throwable) {
            // Ignore when table is unavailable.
        }

        try {
            if (Schema::hasTable('learning_locations')) {
                $locations = LearningLocation::query()->with('owner')->latest()->get();
                foreach ($locations as $location) {
                    if (! $items->contains('slug', $location->slug)) {
                        $items->push($this->mapLearningLocation($location));
                    }
                }
            }
        } catch (Throwable) {
            // Ignore when table is unavailable.
        }

        return $items;
    }

    /**
     * Normalize a `LearningLocation` model into view-ready array data.
     *
     * @return array<string, mixed>
     */
    private function mapLearningLocation(LearningLocation $location): array
    {
        return [
            'id' => $location->id,
            'is_learning_location' => true,
            'title' => $location->name,
            'slug' => $location->slug,
            'category' => $location->category,
            'location' => $location->location,
            'city' => $location->city ?? $location->location,
            'address' => $location->public_address,
            'description' => $location->description,
            'facilities' => $location->facilities ?? [],
            'cost' => $location->cost_info,
            'is_free' => $location->is_free,
            'schedule' => $location->schedule ?? 'Hubungi pengelola untuk jadwal operasional',
            'weekend_open' => $location->weekend_availability,
            'capacity' => $location->capacity,
            'contact_info' => $location->contact_info,
            'age_group' => $location->age_group,
            'access_notes' => $location->access_notes,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'verification_status' => $location->publication_status,
            'image' => $location->image,
            'updated_at' => $location->updated_at,
            'owner' => $location->owner ? [
                'display_name' => $location->owner->display_name,
                'institution' => $location->owner->institution,
                'location' => $location->owner->location,
                'bio' => $location->owner->bio,
            ] : null,
        ];
    }

    /**
     * Normalize a `LearningPlace` model into view-ready array data.
     *
     * @return array<string, mixed>
     */
    private function mapLearningPlace(LearningPlace $place): array
    {
        $image = null;
        if ($place->image) {
            $image = Str::startsWith($place->image, ['http://', 'https://', '/'])
                ? $place->image
                : asset('storage/'.$place->image);
        }

        return [
            'id' => $place->id,
            'is_learning_location' => false,
            'title' => $place->name,
            'slug' => Str::slug($place->name),
            'category' => $place->category,
            'location' => $place->address,
            'city' => $place->address,
            'address' => $place->address,
            'description' => $place->description ?? 'Belum ada deskripsi lengkap untuk tempat belajar ini.',
            'facilities' => [],
            'cost' => 'Belum ditentukan',
            'is_free' => false,
            'schedule' => 'Hubungi pengelola untuk informasi jadwal operasional.',
            'weekend_open' => false,
            'capacity' => null,
            'contact_info' => null,
            'age_group' => 'Terbuka untuk pelajar & umum',
            'access_notes' => null,
            'latitude' => null,
            'longitude' => null,
            'verification_status' => 'Belum Diverifikasi',
            'image' => $image,
            'updated_at' => $place->updated_at,
            'owner' => null,
        ];
    }
}
