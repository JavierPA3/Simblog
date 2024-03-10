<?php
    namespace App\Controllers;
    use Twig\Loader\FilesystemLoader;
    use Twig\Environment;
    use Laminas\Diactoros\Response\HtmlResponse;

    class BaseController {
        protected $templateEngine;

        public function __construct() {
            $loader = new FilesystemLoader("../app/Views");
            $this->templateEngine = new Environment($loader, [
                "debug" => true,
                "cache" => false
            ]);
        }
        public function renderHTML($fileName, $data = []) { // $fileName = String con la ruta del archivo a renderizar, $data = Array con los datos a renderizar
            return new HtmlResponse($this->templateEngine->render($fileName, $data));
           
            // $loader = new FilesystemLoader("../app/Views");
            // $this->templateEngine = new \Twig\Environment($loader, [
            //     "debug" => true,
            //     "cache" => false
            // ]);
            // echo $this->templateEngine->render($fileName, $data);
        }
        
    }
