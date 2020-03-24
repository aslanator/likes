<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Like;
use App\Services\LikeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Add like
     *
     * @param \Illuminate\Http\Request $request
     * @param string $modelName
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request, string $modelName, int $id)
    {
        $user = Auth::user();
        $likeService = new LikeService();
        return $likeService->like($modelName, $id, $user);
    }

    /**
     * Remove like
     *
     * @param Request $request
     * @param string $modelName
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, string $modelName, int $id)
    {
        $user = Auth::user();
        $likeService = new LikeService();
        return $likeService->unlike($modelName, $id, $user);
    }
}
