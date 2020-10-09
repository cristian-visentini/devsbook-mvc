<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler ; //as HandlersLoginHandler
//use \src\LoginHandler;

class LoginController extends Controller {

    //private $LoggedUser;

    public function signin(){

        
        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }


        $this->render('signin', [
            'flash' => $flash
        ]);

    }

    public function signinAction(){

        $Email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $Password= filter_input(INPUT_POST, 'password');

        if($Email && $Password){

            
            $Token = LoginHandler::VerifyLogin($Email, $Password);

            if($Token){
                
                $_SESSION['token'] = $Token;
                $this->redirect('/');
                
            }else{
                
                $_SESSION['flash'] = 'Email ou senha não conferem';
                $this->redirect('/login');
               
            }

        }else{
            $_SESSION['flash'] = 'Digite os campos de email/ou senha!';
            $this->redirect('/login');
            
        }
    }

    public function singnup(){
         
        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }


        $this->render('singnup', [
            'flash' => $flash
        ]);
        
    }

    public function singnupAction(){
        $Email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $Password= filter_input(INPUT_POST, 'password');
        $Name= filter_input(INPUT_POST, 'name');
        $BirthDate= filter_input(INPUT_POST, 'birthdate');

        if($Name && $Email && $Password && $BirthDate){
            $BirthDate = explode('/', $BirthDate);
            if(count($BirthDate) !=3){
                $_SESSION['flash'] = 'Data de Nacimento Inválida';
                $this->redirect('/cadastro');
            }
                $BirthDate = $BirthDate[2].'-'.$BirthDate[1].'-'.$BirthDate[0];

                if(strtotime($BirthDate) === false){
                    $_SESSION['flash'] = 'Data de Nacimento Inválida';
                $this->redirect('/cadastro');
                }

                if(LoginHandler::EmailExists($Email) === false){
                   $Token =  LoginHandler::AddUser($Name, $Email, $Password, $BirthDate);
                   $_SESSION['token'] = $Token;
                   $this->redirect('/');
                }else{
                    $_SESSION['flash'] = 'Email Já CAdastrado';
                $this->redirect('/cadastro');
                }
            

        }else{
            $this->redirect('/cadastro');
        }
    
    }
}

