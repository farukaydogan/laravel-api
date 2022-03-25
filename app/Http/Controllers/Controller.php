<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info (
 *     version="2.0.0",
 *     title="Laravel API Documentation",
 *     description="This is a sample Laravel API documentation.",
 *     termsOfService="http://localhost:8000/api/terms",
 *     @OA\Contact (email="babrrsdern@gmail.com"),
 *     @OA\License (name="Apache 2.4.0", url="http://www.apache.org/licenses/LICENSE-2.4.html")
 * ),
 *
 * @OA\Server (
 *     description="Laravel Api Test Server",
 *     url="http://localhost:8000/api"
 * ),
 *
 * @OA\Server (
 *     description="Laravel Api Stage Server",
 *     url="http://localhost:8000/stage/api"
 * ),
 *
 * @OA\ExternalDocumentation (
 *     description="Find out more abaut Laravel API documentation",
 *     url="http://localhost:8000/api/ext-documentation"
 * ),
 *
 * @OA\Tag (
 *     name="product",
 *     description="Api product operations",
 *     @OA\ExternalDocumentation (
 *         description="Find Out More",
 *         url="http://localhost:8000/api/documentation/product"
 *     )
 * ),
 * @OA\SecurityScheme (
 *     type="apiKey",
 *     name="api_token",
 *     securityScheme="api_token",
 *     in="query"
 * )
 *
 * @OA\SecurityScheme (
 *     type="http",
 *     name="bearer_token",
 *     securityScheme="bearer_token",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
