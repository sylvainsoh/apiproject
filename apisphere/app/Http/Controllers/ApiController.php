<?php
namespace App\Http\Controllers;

use App\Models\ExpressionHandler;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Email generator",
 *      description="API for generating emails from inputs"
 * )
 *
 */

class ApiController extends Controller
{
    public function emailGenerator(\App\Http\Requests\EmailGeneratorRequest $request)
    {
        // Get data from the request url
        $data = $request->validated();

        //Get inputs
        $inputs = $data['inputs'];

        //Handle expression
        $expressionHandler = new ExpressionHandler($inputs, $data['expression']);

        try {
            $result = $expressionHandler->getResult();
        } catch (\Exception $ex) {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
                'error' => $ex->getMessage(),
            ], \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        // Format return type
        return json_encode(
            [
                'data' => [
                    [
                        'id' => $result,
                        'value' => $result
                    ]
                ]
            ]
        );
    }
}
