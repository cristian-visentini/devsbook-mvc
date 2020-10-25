<?php

namespace src\controllers;

use \core\Controller;
use DateTime;
use \src\handlers\UserHandler;
//use \src\handlers\PostHandler;

class ConfigController extends Controller
{

    private $LoggedUser;

    public function __construct()
    {
        $this->LoggedUser = UserHandler::CheckLogin();

        if ($this->LoggedUser === false) {
            $this->redirect('/login');
        }
    }

    public function index()
    {
        $User = UserHandler::GetUser($this->LoggedUser->Id);

        $Flash = '';
        if (!empty($_SESSION['flash'])) {
            $Flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $this->render('configuration', [
            'LoggedUser' => $this->LoggedUser,
            'User' => $User,
            'Flash' => $Flash
        ]);
    }

    public function ConfigAction()
    {
        $Name = filter_input(INPUT_POST, 'name');
        $Email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $BirthDate = filter_input(INPUT_POST, 'birthdate');
        $Work = filter_input(INPUT_POST, 'work');
        $City = filter_input(INPUT_POST, 'city');
        

        $Password = filter_input(INPUT_POST, 'password');
        $New_Password = filter_input(INPUT_POST, 'new_password');
 

        if ($Name && $Email && $BirthDate) {

            //verificando se nao existe outro usuario com o mesmo email
            if (UserHandler::EmailExists($Email) && $Email != $this->LoggedUser->Email) {

                $_SESSION['flash'] = 'Email já existe';
                $this->redirect('/configuration');
            }

            //verificando se a data de nascimento e valida

            $BirthDate = explode('/', $BirthDate);
            if (count($BirthDate) != 3) {
                $_SESSION['flash'] = 'Data de Nacimento Inválida';
                $this->redirect('/configuration');
            }
            $BirthDate = $BirthDate[2].'-'. $BirthDate[1].'-'.$BirthDate[0];

            if (strtotime($BirthDate) === false) {
                $_SESSION['flash'] = 'Data de Nacimento Inválida';
                $this->redirect('/configuration');
            }

            if ($Password) {
                if ($Password != $New_Password) {
                    $_SESSION['flash'] = 'As senhas não coicidem';
                    $this->redirect('/configuration');
                }
            }

            //Convertendo os primeiros caracteres do nome para maiusculo
            $Name = explode(' ', $Name);
            $Name = ucfirst($Name[0]).' '.ucfirst($Name[1]);

            //AVATAR
            
            if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])){
                $New_Avatar = $_FILES['avatar'];

                
                if(in_array($New_Avatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])){
                    $Avatar_Name = $this->CutImage($New_Avatar, 200, 200, 'media/avatars');
                }
            }


            //Cover

            if(isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])){
                $New_Cover = $_FILES['cover'];

                if(in_array($New_Cover['type'], ['image/jpeg', 'image/jpg', 'image/png'])){
                    $Cover_Name = $this->CutImage($New_Cover, 850, 310, 'media/covers');
                }
            }


            UserHandler::UpdateUser($this->LoggedUser->Id, $Email, $Name, $BirthDate, 
            $Password, $Work, $City, $Cover_Name, $Avatar_Name);
        } else {
            $_SESSION['flash'] = 'Os campos com * são obrigatórios';
        }

        $this->redirect('/configuration');
    }

    private function CutImage($File, $W, $H, $Folder){
        list($Width_origin, $Height_Origin) = getimagesize($File['tmp_name']);
        $Ratio = $Width_origin/$Height_Origin;

        

        $New_Width = $W;
        $New_Height = $New_Width/$Ratio;

        if($New_Height <$H){
            $New_Height = $H;
            $New_Width = $New_Height * $Ratio;
        }

        $X = $W - $New_Width;
        $Y = $H - $New_Height;

        $X = $X < 0 ? $X/2 : $X;
        $Y = $Y < 0 ? $Y/2 : $Y;

        $FinalImage =  imagecreatetruecolor($X, $Y);

        switch($File['type']){
            case 'image/jpeg':
            case 'image/jpg':

                $Image = imagecreatefromjpeg($File['tmp_name']);
            break;
            case 'image/png':
                $Image = imagecreatefrompng($File['tmp_name']);
            break;
        }

        imagecopyresampled(
            $FinalImage, $Image,
            $X, $Y, 0, 0,
            $New_Width, $New_Height,
            $Width_origin, $Height_Origin
        );

        $FileName = md5(time().rand(0, 999)).'.jpg';

        imagejpeg($FinalImage, $Folder.'/'.$FileName);

        return $FileName;
    }
}
