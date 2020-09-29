<?php
namespace src\handlers;
use \core\Model;
use \src\models\User;

class LoginHandler{
    public static function CheckLogin(){
        if(!empty($_SESSION['token'])){
            $Token = $_SESSION['token'];

            $Data = User::select()->where('token', $Token)->one();

            if(count($Data) > 0){

                $LoggedUser = new User();

                $LoggedUser->Id = $Data['id'];
                $LoggedUser->Email = $Data['email'];
                $LoggedUser->Name = $Data['name'];

                return $LoggedUser;

            }
        }
          return false;
    }
}