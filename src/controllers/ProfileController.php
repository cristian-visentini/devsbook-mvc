<?php
namespace src\controllers;

use \core\Controller;
use DateTime;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class ProfileController extends Controller {

    private $LoggedUser;

    public function __construct(){
        $this->LoggedUser = UserHandler::CheckLogin();

        if($this->LoggedUser === false){
            $this->redirect('/login');
        }

    }

    public function index($Atts =[]) {
        $Page = intval(filter_input(INPUT_GET,'page'));

        $id = $this->LoggedUser->Id;

        if(!empty($Atts['id'])){
            $id = $Atts['id'];
        }
       
        $User = UserHandler::GetUser($id, true);

        if(!$User){
            $this->redirect('/');
        }

        $DateFrom = new \DateTime($User->BirthDate);
        $DateTo = new \DateTime('today');


        $User->AgeYears = $DateFrom->diff($DateTo)->y;

        $Feed = PostHandler::GetUserFeed($id, $Page, $this->LoggedUser->Id);
        
        $this->render('profile',[
            'LoggedUser' => $this->LoggedUser,
            'User' => $User,
            'Feed' => $Feed
        ]);
    }
}