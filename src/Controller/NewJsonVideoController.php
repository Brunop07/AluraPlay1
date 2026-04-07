<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Controller\Controller;
use Alura\Mvc\Repository\VideoRepository;

class NewJsonVideoListController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        ob_clean();
        $request = file_get_contents('php://input');
        $videodata = json_decode($request, true);
        $video = new Video();
        $video->url = $videodata['url'];
        $video->title = $videodata['titulo'];
        $this->videoRepository->add($video);

        http_response_code(201);
        header('Content-Type: application/json');

        
    }
}