<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model as Eloquent;
    use Illuminate\Capsule\Manager as Capsule;
    use App\Models\Comment;

    class Blog extends Eloquent{
        
        protected $table = "blog";

        const CREATED_AT = "created";
        const UPDATED_AT = "updated";

        protected $fillable = ["id", "title", "author", "blog", "image", "tags", "created", "updated"];

        public function comment() {
            return $this->hasMany(Comment::class);
        }

        public function getComments() {
            return $this->comments;
        }

        public function numComments(){
            return $this -> comments ? count($this->comments) :0;
        }

        
    }