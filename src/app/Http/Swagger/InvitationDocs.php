<?php

namespace App\Http\Swagger;

use OpenApi\Attributes as OA;

class InvitationDocs
{
    #[OA\Get(
        path: '/api/invitations',
        summary: 'Listar convites',
        tags: ['Invitations'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista paginada de convites'),
            new OA\Response(response: 401, description: 'Não autenticado'),
            new OA\Response(response: 403, description: 'Sem permissão — apenas Admin'),
        ]
    )]
    public function index() {}

    #[OA\Post(
        path: '/api/invitations',
        summary: 'Enviar convite',
        tags: ['Invitations'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'novo@email.com'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Convite enviado com sucesso'),
            new OA\Response(response: 401, description: 'Não autenticado'),
            new OA\Response(response: 403, description: 'Sem permissão — apenas Admin'),
            new OA\Response(response: 422, description: 'Email inválido ou já cadastrado'),
        ]
    )]
    public function store() {}

    #[OA\Get(
        path: '/api/invitations/{token}',
        summary: 'Validar convite',
        tags: ['Invitations'],
        parameters: [
            new OA\Parameter(name: 'token', in: 'path', required: true,
                schema: new OA\Schema(type: 'string', example: 'uuid-token-aqui')
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Dados do convite'),
            new OA\Response(response: 404, description: 'Convite não encontrado'),
        ]
    )]
    public function show() {}
}
