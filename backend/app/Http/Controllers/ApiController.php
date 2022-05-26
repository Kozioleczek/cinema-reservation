<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/index",
     *     tags={"Cinema"},
     *     security={{"passport": {"*"}}},
     *
     *     @OA\Response(response=200, description="OK"),
     * )
     *
     */
    public function test() {

    }
}
