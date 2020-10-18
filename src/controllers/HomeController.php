<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class HomeController extends Controller {

    private $LoggedUser;

    public function __construct(){
        $this->LoggedUser = UserHandler::CheckLogin();

        if($this->LoggedUser === false){
            $this->redirect('/login');
        }

    }

    public function index() {

        $Page = intval(filter_input(INPUT_GET,'page'));
        $Feed = PostHandler::GetHomeFeed(
            $this->LoggedUser->Id,
            $Page
        );
        
        $this->render('home', [
            'LoggedUser' => $this->LoggedUser,
            'Feed' => $Feed
        ]);
    }
}