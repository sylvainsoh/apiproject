<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;


/**
 * @OA\Get(
 *      path="/api/v1.0/emails-generator",
 *     summary="Email generation",
 *     description="Generate Email from inputs based on expression",
 *     @OA\Parameter(
 *         name="input1",
 *         description="input1",
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="input2",
 *         description="input2",
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *
 *     @OA\Parameter(
 *         name="input3",
 *         description="input3",
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *
 *     @OA\Parameter(
 *         name="input4",
 *         description="input4",
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *
 *     @OA\Parameter(
 *         name="input5",
 *         description="input5",
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="input6",
 *         description="input6",
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *
 *     @OA\Parameter(
 *         name="expression",
 *         description="expression",
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Generated email from inputs and expressions",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                property="data",
 *                type="array",
 *                @OA\Items(
 *                      @OA\Property(
 *                         property="id",
 *                         type="string",
 *                         example="jl.mMignard@external.peoplespheres.fr"
 *                      ),
 *                      @OA\Property(
 *                         property="value",
 *                         type="string",
 *                         example="jl.mMignard@external.peoplespheres.fr"
 *                      )
 *                ),
 *             ),
 *         )
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
