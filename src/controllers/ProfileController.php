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
        $id = $this->LoggedUser->Id;
        
        if(!empty($Atts['id'])){
            $id = $Atts['id'];
        }
       
        
        $this->render('profile',[
            'LoggedUser' => $this->LoggedUser
        ]);
    }
}