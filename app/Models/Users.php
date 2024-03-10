<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model as Eloquent;
    use Illuminate\Capsule\Manager as Capsule;
    use App\Models\Comment;

    class Users extends Eloquent{
        
        protected $table = "users";

        const CREATED_AT = "created";
        const UPDATED_AT = "updated";

        protected $fillable = ["id", "user", "password", "email", "profile", "created", "updated"];
        
    }