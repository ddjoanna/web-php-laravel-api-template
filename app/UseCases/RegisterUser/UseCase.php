<?php

namespace App\UseCases\RegisterUser;

use App\UseCases\RegisterUser\Request;
use App\UseCases\RegisterUser\Response;

class UseCase
{
    public function __construct()
    {
        //
    }

    public function execute(Request $request): Response
    {
        
        $response = new Response();

        return $response;
    }
}
