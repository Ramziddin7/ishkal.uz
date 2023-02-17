<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
        /** 
     * @OA\Info(
     *      version="1.0.0",
     *      title="World UZ",
     *      description="Documentation for World Uz Company",
     *      @OA\Contact(
     *          email="rustamovramziddin7@gmail.com"
     *      ),
     * ),
     * 
     *     * @OA\SecurityScheme(
     *     type="http",
     *     description="Login with email and password to get the authentication token",
     *     name="Token based Based",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="api",
     * ),
     * 
     * 
     *  @OA\Tags(
     *  name="Country",
     *  description="This is a country docs",
     * ),
     *   @OA\Tags(
     *  name="University",
     *  description="This is a University docs",
     * ),
     *  @OA\Tags(
     *  name="Field",
     *  description="This is a fields docs",
     * ),
     * @OA\Tags(
     * name="Auth",
     * description="This is auth docs",
     * )
     * 
     */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
