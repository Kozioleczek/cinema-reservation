<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\MovieResource;
use App\Models\Employee;
use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/movie/index",
     *
     *     @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/MovieResource")
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $movies = Movie::query()->get();

        return MovieResource::collection($movies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMovieRequest $request
     * @return Response
     */
    public function store(StoreMovieRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Movie $movie
     * @return Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMovieRequest $request
     * @param Movie $movie
     * @return Response
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Movie $movie
     * @return Response
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
