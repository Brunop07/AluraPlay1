<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;

namespace Alura\Mvc\Controller;

interface Controller
{
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface;
}
