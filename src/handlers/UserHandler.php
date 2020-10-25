<?php

namespace src\handlers;

use \core\Model;
use \src\models\User;
use \src\models\UserRelation;
//use \src\models\Post;
use \src\handlers\PostHandler;

class UserHandler
{
    public static function CheckLogin()
    {
        if (!empty($_SESSION['token'])) {
            $Token = $_SESSION['token'];

            $Data = User::select()->where('token', $Token)->one();

            if (count($Data) > 0) {

                $LoggedUser = new User();

                $LoggedUser->Id = $Data['id'];
                $LoggedUser->Email = $Data['email'];
                $LoggedUser->Name = $Data['name'];
                $LoggedUser->Avatar = $Data['avatar'];

                return $LoggedUser;
            }
        }
        return false;
    }

    public static function VerifyLogin($Email, $Password)
    {
        $User = User::select()->where('email', $Email)->one();

        if ($User) {
            if (password_verify($Password, $User['password'])) {
                $Token = md5(time() . rand(0, 9999) . time());

                User::update()->set('token', $Token)->where('email', $Email)->execute();
                return $Token;
            }
        }
        return false;
    }

    public function IdExists($Id)
    {
        $User = User::select()->where('id', $Id)->one();
        return $User ? true : false;
    }

    public function EmailExists($Email)
    {
        $User = User::select()->where('email', $Email)->one();
        return $User ? true : false;
    }

    public function GetUser($id, $full = false)
    {
        $Data = User::select()->where('id', $id)->one();

        if ($Data) {
            $User = new User();
            $User->Id = $Data['id'];
            $User->Name = $Data['name'];
            $User->BirthDate = $Data['birthdate'];
            $User->City = $Data['city'];
            $User->Work = $Data['work'];
            $User->Avatar = $Data['avatar'];
            $User->Cover = $Data['cover'];

            if ($full) {
                $User->Followers = [];
                $User->Following = [];
                $User->Photos = [];

                //Followers
                $Followers = UserRelation::select()->where('user_to', $id)->get();
                foreach ($Followers as $Follower) {
                    $UserData = User::select()->where('id', $Follower['user_from'])->one();
                    
                    $NewUser = new User();
                   
                    $NewUser->Id = $UserData['id']; // o erro ocorre nesses campos
                    $NewUser->Name = $UserData['name'];
                    $NewUser->Avatar = $UserData['avatar'];


                    $User->Followers[] = $NewUser;
                }

                //Following
                $Following = UserRelation::select()->where('user_from', $id)->get();
                foreach ($Following as $Follower) {
                    $UserData = User::select()->where('id', $Follower['user_to'])->one();
                    $NewUser = new User();
                    $NewUser->Id = $UserData['id'];
                    $NewUser->Name = $UserData['name'];
                    $NewUser->Avatar = $UserData['avatar'];

                    $User->Following[] = $NewUser;
                }

                //Photos
                $User->Photos = PostHandler::GetPhotosFrom($id);
            }

            return $User;
        }
    }

    public function AddUser($Name, $Email, $Password, $BirthDate)
    {
        $Hash = password_hash($Password, PASSWORD_DEFAULT);
        $Token = md5(time() . rand(0, 9999) . time());

        User::insert([
            'email' => $Email,
            'password' => $Hash,
            'name' => $Name,
            'birthdate' => $BirthDate,
            'avatar' => 'default.jpg',
            'cover' => 'cover.jpg',
            'token' => $Token
        ])->execute();

        return $Token;
    }

    public static function IsFollowing($From, $To)
    {
        $Data = UserRelation::select()
            ->where('user_from', $From)
            ->where('user_to', $To)
        ->one();

        if($Data){
            return true;
        }

        return false;
        
    }

    public function Follow($From, $To){
        UserRelation::insert([
            'user_from' => $From,
            'user_to' => $To
        ])->execute();
    }

    public function Unfollow($From, $To){
        UserRelation::delete()
            ->where('user_from', $From)
            ->where('user_to', $To)
        ->execute();
    }

    public static function SearchUser($SearchTerm){
        $Users=[];
        $Data = User::select()->where('name', 'like', '%'.$SearchTerm.'%')->get();

        if($Data){
            foreach($Data as $User){
                $NewUser = new User();
                $NewUser->Id = $User['id'];
                $NewUser->Name = $User['name'];
                $NewUser->Avatar = $User['avatar'];

                $Users[] =$NewUser;
            }
        }


        return $Users;

    }

    public static function UpdateUser($Id, $Email, $Name, $BirthDate, $Password=false, $Work=false, $City=false){
       if($Password){
        $Hash = password_hash($Password, PASSWORD_DEFAULT);
       }

       if($Email){
        User::update()
            ->set('email' , $Email)
            ->where('id', $Id)
       ->execute();
       }

       if($Name){
        User::update()
            ->set('name' , $Name)
            ->where('id', $Id)
       ->execute();
       }

       if($Hash){
        User::update()
        ->set('password' , $Hash)
            ->where('id', $Id)
       ->execute();
       }

       if($Work){
        User::update()
        ->set('work' , $Work)
            ->where('id', $Id)
       ->execute();
       }

       if($BirthDate){
        User::update()
        ->set('birthdate' , $BirthDate)
            ->where('id', $Id)
       ->execute();
       }

       if($City){
        User::update()
        ->set('city' , $City)
            ->where('id', $Id)
       ->execute();
       }
       

       /*
       ->set('password' , $Hash)
            ->set('name' , $Name)
            ->set('birthdate' , $BirthDate)
       
       
       */

    }
}
