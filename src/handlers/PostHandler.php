<?php
namespace src\handlers;
use \core\Model;
use \src\models\Post;

class PostHandler{

    public static function AddPost($Id_User, $Type, $Body){
        $Body = trim($Body);
        if(!empty($Id_User) && !empty($Body)){

            Post::insert([
                'id_user' => $Id_User,
                'type' => $Type,
                'created_at' => date('Y-m-d H:m:s'),
                'body' => $Body
            ])->execute();
        }

    }

}