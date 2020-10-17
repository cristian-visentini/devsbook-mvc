<?php
namespace src\handlers;
use \core\Model;
use \src\models\Post;
use \src\models\User;
use \src\models\UserRelation;

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

    public static function GetHomeFeed($Id_User, $Page){
        $PerPage = 2;

     //Pegar lista de usuarios que sigo

     $UserList = UserRelation::select()->where('user_from', $Id_User)->get();
     $Users = [];

     foreach($UserList as $UserItem){
        $Users[] = $UserItem['user_to'];
     }

     $Users[] = $Id_User;
     

     // pegar posts ordenados por data

     $PostList = Post::select()->where('id_user', 'in', $Users)->orderBy('created_at', 'desc')->page($Page, $PerPage)->get();

     $Total = Post::select()->where('id_user', 'in', $Users)->count();

     $PageCount = ceil($Total / $PerPage);

     // Transformar em objetos dos models

     $Posts = [];

     foreach($PostList as $PostItem){
        $NewPost = new Post();
        $NewPost->Id = $PostItem['id'];
        $NewPost->Type = $PostItem['type'];
        $NewPost->Created_At = $PostItem['created_at'];
        $NewPost->Body = $PostItem['body'];
        $NewPost->Mine = false;

        if($PostItem['id_user'] == $Id_User){
            $NewPost->Mine = true;
        }

        // Prencher informações adicionais nos posts

        $NewUser = User::select()->where('id', $PostItem['id_user'])->one();
        $NewPost->User = new User();
        $NewPost->User->Id = $NewUser['id'];
        $NewPost->User->Name = $NewUser['name'];
        $NewPost->User->Avatar = $NewUser['avatar'];


        //prencher informações de likes
        $NewPost->LikeCount = 0;
        $NewPost->Liked = false;

        //prencher informações de coments
        $NewPost->Coments = [];


        $Posts[] = $NewPost;
     }

     //retornar resultado
     return [
         'Posts' => $Posts,
        'PageCount' => $PageCount,
        'CurrentPage' => $Page
        ];
    }

}