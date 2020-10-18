<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;
use \src\handlers\PostHandler;

class ProfileController extends Controller {

    private $LoggedUser;

    public function __construct(){
        $this->LoggedUser = LoginHandler::CheckLogin();

        if($this->LoggedUser === false){
            $this->redirect('/login');
        }

    }

    public function index($Atts =[]) {

       
        
        $this->render('profile',[
            'LoggedUser' => $this->LoggedUser
            ]);
    }
}