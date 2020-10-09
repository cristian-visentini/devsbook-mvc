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

    public static function VerifyLogin($Email, $Password){
        $User = User::select()->where('email', $Email)->one();

        if($User){
            if(password_verify($Password, $User['password'])){
                $Token = md5(time().rand(0, 9999).time());

                User::update()->set('token', $Token)->where('email', $Email)->execute();
                return $Token;
            }
            
        }
        return false;
    }

    public function EmailExists($Email){
        $User = User::select()->where('email', $Email)->one();
        return $User ? true : false;
    }

    public function AddUser($Name, $Email, $Password, $BirthDate){
        $Hash = password_hash($Password, PASSWORD_DEFAULT);
        $Token = md5(time().rand(0, 9999).time());

        User::insert([
            'email' => $Email,
            'password' => $Hash,
            'name' => $Name,
            'birthdate' => $BirthDate,
            'avatar' => 'defaeult.jpg',
            'cover' => 'cover.jpg',
            'token' => $Token
        ])->execute();

        return $Token;

    }
}