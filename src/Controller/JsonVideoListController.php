<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Controller\Controller;
use Alura\Mvc\Repository\VideoRepository;

class JsonVideoListController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        ob_clean();
        $videoList = array_map(function (Video $video): array {
            return [
                'url' => $video->url,
                'titulo' => $video->title,
                'filePath' => $video->getFilePath()
            ];
        }, $this->videoRepository->all());

        header('Content-Type: application/json');
        echo json_encode($videoList);
    }
}