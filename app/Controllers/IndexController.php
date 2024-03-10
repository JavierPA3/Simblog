<?php
    namespace App\Controllers;
    use App\Models\Blog;

    class IndexController extends BaseController{
        public function indexAction(){

            $data = [
                "blogs" => $blogs = Blog::all(),
                "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : null,
                "perfil" => isset($_SESSION["perfil"]) ? $_SESSION["perfil"] : null,


            ];  
            return $this->renderHTML("index_view.twig", $data); // La ruta parte de la ubicacion del fichero index.php
        }
        public function aboutAction(){
            return $this->renderHTML("aboutMe.twig");
        }
        public function contactoAction(){
            return $this->renderHTML("contactos.twig");
        }
    }
