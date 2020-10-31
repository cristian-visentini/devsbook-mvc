<?php

namespace src\handlers;

use \core\Model;
use \src\models\Post;
use \src\models\PostLike;
use \src\models\PostComment;
use \src\models\User;
use \src\models\UserRelation;

class PostHandler
{

    public static function AddPost($Id_User, $Type, $Body)
    {
        $Body = trim($Body);
        if (!empty($Id_User) && !empty($Body)) {

            Post::insert([
                'id_user' => $Id_User,
                'type' => $Type,
                'created_at' => date('Y-m-d H:m:s'),
                'body' => $Body
            ])->execute();
        }
    }

    public function _PostListToObject($PostList, $LoggedUserId)
    {
        $Posts = [];

        foreach ($PostList as $PostItem) {
            $NewPost = new Post();
            $NewPost->Id = $PostItem['id'];
            $NewPost->Type = $PostItem['type'];
            $NewPost->Created_At = $PostItem['created_at'];
            $NewPost->Body = $PostItem['body'];
            $NewPost->Mine = false;

            if ($PostItem['id_user'] == $LoggedUserId) {
                $NewPost->Mine = true;
            }

            // Prencher informações adicionais nos posts

            $NewUser = User::select()->where('id', $PostItem['id_user'])->one();
            $NewPost->User = new User();
            $NewPost->User->Id = $NewUser['id'];
            $NewPost->User->Name = $NewUser['name'];
            $NewPost->User->Avatar = $NewUser['avatar'];


            //prencher informações de likes

            $Likes = PostLike::select()->where('id_post', $PostItem['id'])->get();

            $NewPost->LikeCount = count($Likes);
            $NewPost->Liked = self::IsLiked($PostItem['id'], $LoggedUserId);

            //prencher informações de coments
            $NewPost->Coments = PostComment::select()->where('id_post', $PostItem['id'])->get();
            foreach ($NewPost->Coments as $Key => $Coment) {
                $NewPost->Coments[$Key]['user'] = User::select()->where('id', $Coment['id_user'])->one();
            }


            $Posts[] = $NewPost;
        }
        return $Posts;
    }

    public static function IsLiked($ID, $LoggedUserId)
    {

        $MyLike = PostLike::select()
            ->where('id_post', $ID)
            ->where('id_user', $LoggedUserId)
            ->get();


        if (count($MyLike) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function DeleteLike($Id, $LoggedUserId)
    {

        PostLike::delete()
            ->where('id_post', $Id)
            ->where('id_user', $LoggedUserId) // o erro estava nesta linha, havia colocado ponto ao inves de , para separar id_user de $loggedUserId
            ->execute();
    }

    public static function AddLike($Id, $LoggedUserId)
    {

        PostLike::insert([
            'id_post' => $Id,
            'id_user' => $LoggedUserId,
            'created_at' => date('Y-m-d H:i:s')
        ])->execute();
    }


    public static function AddComent($Id, $Txt, $LoggedUser)
    {

        PostComment::insert([
            'id_post' => $Id,
            'id_user' => $LoggedUser,
            'created_at' => date('Y-m-d H:i:s'),
            'body' => $Txt
        ])->execute();
    }

    public static function GetUserFeed($IdUser, $Page, $LoggedUserId)
    {
        $PerPage = 2;
        // pegar posts ordenados por data

        $PostList = Post::select()->where('id_user', $IdUser)->orderBy('created_at', 'desc')->page($Page, $PerPage)->get();

        $Total = Post::select()->where('id_user', $IdUser)->count();

        $PageCount = ceil($Total / $PerPage);

        // Transformar em objetos dos models

        $Posts = self::_PostListToObject($PostList, $LoggedUserId);
        //retornar resultado
        return [
            'Posts' => $Posts,
            'PageCount' => $PageCount,
            'CurrentPage' => $Page
        ];
    }

    public static function GetHomeFeed($Id_User, $Page)
    {
        $PerPage = 2;

        //Pegar lista de usuarios que sigo

        $UserList = UserRelation::select()->where('user_from', $Id_User)->get();
        $Users = [];

        foreach ($UserList as $UserItem) {
            $Users[] = $UserItem['user_to'];
        }

        $Users[] = $Id_User;


        // pegar posts ordenados por data

        $PostList = Post::select()->where('id_user', 'in', $Users)->orderBy('created_at', 'desc')->page($Page, $PerPage)->get();

        $Total = Post::select()->where('id_user', 'in', $Users)->count();

        $PageCount = ceil($Total / $PerPage);

        // Transformar em objetos dos models

        $Posts = self::_PostListToObject($PostList, $Id_User);
        //retornar resultado
        return [
            'Posts' => $Posts,
            'PageCount' => $PageCount,
            'CurrentPage' => $Page
        ];
    }

    public function GetPhotosFrom($Id_User)
    {
        $PhotosData = Post::select()
            ->where('id_user', $Id_User)
            ->where('type', 'photo')
            ->get();

        $Photos = [];

        foreach ($PhotosData as $Photo) {
            $NewPost = new Post();
            $NewPost->Id = $Photo['id'];
            $NewPost->Created_At = $Photo['created_at'];
            $NewPost->Type = $Photo['type'];
            $NewPost->Body = $Photo['body'];

            $Photos[] = $NewPost;
        }

        return $Photos;
    }

    public static function delete($Id, $LoggedUserId)
    {
        //verificar se post existe e se e de loggeduser
        $Post = Post::select()
            ->where('id', $Id)
            ->where('id_user', $LoggedUserId)
            ->get();

        if (count($Post) > 0) {
            $Post = $Post[0];

            //deletar likes e comments

            PostLike::delete()->where('id_post', $Id)->execute();
            PostComment::delete()->where('id_post', $Id)->execute();

            //se foto deletar arquivo tambem

            if($Post['type'] === 'photo'){
                $Img = __DIR__.'/../../public/media/uploads/'.$Post['body'];
                if(file_exists($Img)){
                    unlink($Img);
                }
            }
        }

        //deletar o post de fato
        Post::delete()->where('id', $Id)->execute();
    }
}
