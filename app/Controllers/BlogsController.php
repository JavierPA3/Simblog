<?php
    namespace App\Controllers;
    use App\Models\Blog;
    use \Respect\Validation\Validator as v;

    class BlogsController extends BaseController{
        public function blogsAction($request){
            if ($request->getMethod() == "POST"){
                $validador = v::key('title', v::stringType()->notEmpty())
                    ->key('author', v::stringType()->notEmpty())
                    ->key('blog', v::stringType()->notEmpty())
                    ->key('tags', v::stringType()->notEmpty());
                try {
                    $validador->assert($request->getParsedBody());
                    $blog = new Blog();
                    $blog->title = $request->getParsedBody()['title'];
                    $blog->author = $request->getParsedBody()['author'];
                    $blog->blog = $request->getParsedBody()['blog'];
                    $blog->tags = $request->getParsedBody()['tags'];

                    $files = $request->getUploadedFiles();
                    $image = $files['image'];
                    if ($image->getError() == UPLOAD_ERR_OK) {
                        $fileName = $image->getClientFilename();
                        $fileName = uniqid().$fileName;
                        $image->moveTo("img/$fileName");
                        $blog->image = $fileName;
                    }
                    $blog->save();
                    header("Location: /");
                }
                catch(\Exception $e) {
                    $response = "Error: ".$e->getMessage();
                }
            }
            $data = [
                "response" => $response ?? "",
            ];
            return $this->renderHTML("addBlog.twig", $data);
        }
    }