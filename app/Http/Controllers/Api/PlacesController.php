<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PlacesController extends Controller
{
    /**
     * List places.
     *
     * List all places that can be booked by the user. The user can filter the list by price range and sort the results.
     *
     * @response AnonymousResourceCollection<LengthAwarePaginator<PlaceResource>>
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'price_from' => ['int'],
            'price_to' => ['int'],
            'sorts' => ['array'],
            'sorts.*.field' => [Rule::in(['price'])],
            'sorts.*.direction' => [Rule::in(['asc', 'desc'])],
        ]);

        $placesQuery = Place::query()
            ->when($request->get('price_from'), fn ($q, $priceFrom) => $q->where('price', '>=', $priceFrom))
            ->when($request->get('price_to'), fn ($q, $priceTo) => $q->where('price', '<=', $priceTo));

        foreach ($request->collect('sorts') as $sort) {
            $placesQuery->orderBy($sort['field'], $sort['direction']);
        }

        return PlaceResource::collection($placesQuery->paginate($request->integer('per_page', 15)));
    }
}
