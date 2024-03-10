<?php
    namespace App\Controllers;
    use App\Models\Users;
    use \Respect\Validation\Validator as v;

    class AdminController extends BaseController{

        public function indexAction($request){
           return $this->renderHTML("admin.twig");
        }

    }