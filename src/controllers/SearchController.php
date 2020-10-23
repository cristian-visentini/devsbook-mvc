<?php
namespace src\controllers;

use \core\Controller;
use DateTime;
use \src\handlers\UserHandler;
//use \src\handlers\PostHandler;

class SearchController extends Controller {

    private $LoggedUser;

    public function __construct(){
        $this->LoggedUser = UserHandler::CheckLogin();

        if($this->LoggedUser === false){
            $this->redirect('/login');
        }

    }

    public function index($Atts =[]) {
        $SearchTerm = filter_input(INPUT_GET,'s');

        if(empty($SearchTerm)){
            $this->redirect('/');
        }

        $Users = UserHandler::SearchUser($SearchTerm);

        
        
        $this->render('search',[
            'LoggedUser' => $this->LoggedUser,
            'SearchTerm' => $SearchTerm,
            'Users' => $Users
        ]);
    }

}