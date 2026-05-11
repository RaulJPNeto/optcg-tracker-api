<?php

namespace App\Http\Swagger;

use OpenApi\Attributes as OA;

class SetDocs
{
    #[OA\Get(
        path: '/api/sets',
        summary: 'Listar Sets',
        tags: ['Sets'],
        parameters: [
            new OA\Parameter(
                name: 'search',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', example: 'Adventure')
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lista paginada de sets'),
        ]
    )]
    public function index() {}

    #[OA\Get(
        path: '/api/sets/{set}',
        summary: 'Buscar Set por ID',
        tags: ['Sets'],
        parameters: [
            new OA\Parameter(
                name: 'set',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Dados do set'),
            new OA\Response(response: 404, description: 'Set não encontrado'),
        ]
    )]
    public function show() {}

    #[OA\Post(
        path: '/api/sets',
        summary: 'Criar Set',
        tags: ['Sets'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['code', 'name'],
                properties: [
                    new OA\Property(property: 'code', type: 'string', example: 'OP15'),
                    new OA\Property(property: 'name', type: 'string', example: 'Adventure on Kami Island'),
                    new OA\Property(property: 'release_date_jp', type: 'string', format: 'date', example: '2026-03-01'),
                    new OA\Property(property: 'release_date_global', type: 'string', format: 'date', example: '2026-06-01'),
                    new OA\Property(property: 'total_cards', type: 'integer', example: 120),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Set criado com sucesso'),
            new OA\Response(response: 401, description: 'Não autenticado'),
            new OA\Response(response: 403, description: 'Sem permissão'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store() {}

    #[OA\Put(
        path: '/api/sets/{set}',
        summary: 'Atualizar Set',
        tags: ['Sets'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'set',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'code', type: 'string', example: 'OP15'),
                    new OA\Property(property: 'name', type: 'string', example: 'Adventure on Kami Island'),
                    new OA\Property(property: 'release_date_jp', type: 'string', format: 'date', example: '2026-03-01'),
                    new OA\Property(property: 'release_date_global', type: 'string', format: 'date', example: '2026-06-01'),
                    new OA\Property(property: 'total_cards', type: 'integer', example: 120),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Set atualizado com sucesso'),
            new OA\Response(response: 401, description: 'Não autenticado'),
            new OA\Response(response: 403, description: 'Sem permissão'),
            new OA\Response(response: 404, description: 'Set não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: '/api/sets/{set}',
        summary: 'Deletar Set',
        tags: ['Sets'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'set',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(response: 204, description: 'Set deletado com sucesso'),
            new OA\Response(response: 401, description: 'Não autenticado'),
            new OA\Response(response: 403, description: 'Sem permissão — apenas Admin'),
            new OA\Response(response: 404, description: 'Set não encontrado'),
        ]
    )]
    public function destroy() {}
}
