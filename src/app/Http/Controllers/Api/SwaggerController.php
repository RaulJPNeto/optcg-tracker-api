<?php

namespace App\Http\Controllers\Api;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'REST API for tracking One Piece TCG Japanese spoilers, deck building and meta analysis.',
    description: 'REST API',
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
)]
#[OA\Server(
    url: 'http://localhost:8000',
    description: 'Local Development Server',
)]
class SwaggerController {}
