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
    
    }
}

