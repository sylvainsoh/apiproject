<?php
namespace App\Http\Controllers;

use App\Models\Input;
use Illuminate\Http\Request;
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
    public function emailGenerator(Request $request)
    {
        // Get data from the request url
        $data = $request->all();
        foreach ($data as $key => $d) {
            if ($key != "expression") {
                $$key = new Input(htmlspecialchars($d));
            } else {
                $$key = $d;
            }
        }
        // Extract data in named variables
        $exp = (str_replace('~', '.', $expression));

        $output = eval("return $exp;");


        //Alternative code for remplacing eval function
        /**
        $evaluate = function() use ($exp) {
        return eval("return $exp;");
        };
        $output = $evaluate();
         **/

        return json_encode(
            [
                'data' => [
                    [
                        'id' => $output,
                        'value' => $output
                    ]
                ]
            ]
        );
    }
}
