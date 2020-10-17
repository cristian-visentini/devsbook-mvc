<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;
use \src\handlers\PostHandler;

class HomeController extends Controller {

    private $LoggedUser;

    public function __construct(){
        $this->LoggedUser = LoginHandler::CheckLogin();

        if($this->LoggedUser === false){
            $this->redirect('/login');
        }

    }

    public function index() {

        $Feed = PostHandler::GetHomeFeed($this->LoggedUser->Id);
        
        $this->render('home', [
            'LoggedUser' => $this->LoggedUser,
            'Feed' => $Feed
        ]);
    }
}