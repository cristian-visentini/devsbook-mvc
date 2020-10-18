<?php

namespace src\handlers;

use \core\Model;
use \src\models\User;
use \src\models\UserRelation;
//use \src\models\Post;

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

    public function IdlExists($Id)
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
                foreach($Followers as $Follower){
                    $UserData = User::select()->where('id', $Follower['user_from'])->get();
                    $NewUser = new User();
                    $NewUser->Id = $UserData['id'];
                    $NewUser->Name = $UserData['name'];
                    $NewUser->Avatar = $UserData['avatar'];

                    $User->Followers[] = $NewUser;
                }

                //Following
                $Following = UserRelation::select()->where('user_from', $id)->get();
                foreach($Following as $Follower){
                    $UserData = User::select()->where('id', $Follower['user_from'])->get();
                    $NewUser = new User();
                    $NewUser->Id = $UserData['id'];
                    $NewUser->Name = $UserData['name'];
                    $NewUser->Avatar = $UserData['avatar'];

                    $User->Following[] = $NewUser;
                }

                //Photos


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
}