<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Pure;

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
     * @OA\Post(
     *      path="/api/movie/store",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(StoreMovieRequest $request): MovieResource
    {
        $movie = Movie::query()->create($request->validated());

        return new MovieResource($movie);
    }

    /**
     * @OA\Get(
     *      path="/api/movie/show/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          description="Movie id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    #[Pure] public function show(Movie $movie): MovieResource
    {
        return new MovieResource($movie);
    }

    /**
     * @OA\Post(
     *      path="/api/movie/update",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function update(UpdateMovieRequest $request, Movie $movie): MovieResource
    {
        $movie->update($request->validated());

        return new MovieResource($movie);
    }

    /**
     * @OA\Delete(
     *      path="/api/movie/destroy",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function destroy(Movie $movie): Response
    {
        $movie->delete();

        return response()->noContent();
    }
}
