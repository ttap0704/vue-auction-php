<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;


/**
 * Action
 */
final class UploadFilesAction
{
    // private $container;

    // public function __construct(ContainerInterface $container)
    // {
    //     $this->contaier = $container;
    // }
    /**
     * Invoke.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $directory = "/Users/leedaegyu/Documents/projects/vue-auction-php/public/assets/uploads";
        $uploadedFiles = $request->getUploadedFiles();
        $result = [];

        if (count($uploadedFiles) > 1) {
            for ($i = 0, $leng = count($uploadedFiles); $i < $leng; $i++) {
                if ($uploadedFiles["file$i"]->getError() === UPLOAD_ERR_OK) {
                    $filename = $this->moveUploadedFile($directory, $uploadedFiles["file$i"]);
                    array_push($result, $filename);
                }   
            }
        } else {
            if ($uploadedFiles["file0"]->getError() === UPLOAD_ERR_OK) {
                $filename = $this->moveUploadedFile($directory, $uploadedFiles["file0"]);
                array_push($result, $filename);
            }   
        }
        

        $response->getBody()->write((string)json_encode($result));

        return $response->withStatus(200);
    }

    private function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
