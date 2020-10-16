<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;
use src\handlers\PostHandler;

class PostController extends Controller {

    private $LoggedUser;

    public function __construct(){
        $this->LoggedUser = LoginHandler::CheckLogin();

        if($this->LoggedUser === false){
            $this->redirect('/login');
        }

    }

    public function new() {
        
        $Body = filter_input(INPUT_POST, 'body');
        
        if($Body){
            PostHandler::AddPost($this->LoggedUser->Id,
            'text',
            $Body
        );
        }

        $this->redirect('/');
    }
}