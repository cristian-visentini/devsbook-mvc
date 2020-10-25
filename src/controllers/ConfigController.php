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
            $BirthDate = $BirthDate[2] . '-' . $BirthDate[1] . '-' . $BirthDate[0];

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


            UserHandler::UpdateUser($this->LoggedUser->Id, $Email, $Name, $BirthDate, $Password, $Work, $City);
        } else {
            $_SESSION['flash'] = 'Os campos com * são obrigatórios';
        }

        $this->redirect('/configuration');
    }
}
