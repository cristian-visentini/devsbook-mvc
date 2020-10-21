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

        //Detectando o usuario acessado

        $id = $this->LoggedUser->Id;

        if(!empty($Atts['id'])){
            $id = $Atts['id'];
        }
       
        //pegando informacoes do usuario

        $User = UserHandler::GetUser($id, true);

        if(!$User){
            $this->redirect('/');
        }

        $DateFrom = new \DateTime($User->BirthDate);
        $DateTo = new \DateTime('today');


        $User->AgeYears = $DateFrom->diff($DateTo)->y;

        //pegando feed do usuario

        $Feed = PostHandler::GetUserFeed($id, $Page, $this->LoggedUser->Id);

        //verificar se nao sigo o usuario

        $IsFollowing = false;
        if($User->Id != $this->LoggedUser->Id){
            $IsFollowing = UserHandler::IsFollowing($this->LoggedUser->Id, $User->Id);

        }
        
        $this->render('profile',[
            'LoggedUser' => $this->LoggedUser,
            'User' => $User,
            'Feed' => $Feed,
            'IsFollowing' => $IsFollowing
        ]);
    }

    public function Follow($att){
        $To = intval($att['id']);

        $Exists = UserHandler::IdExists($To);

        if($Exists){
            if(UserHandler::IsFollowing($this->LoggedUser->Id, $To)){
                //deseguir
                UserHandler::Unfollow($this->LoggedUser->Id, $To);

            }else{
                //seguir
                UserHandler::Follow($this->LoggedUser->Id, $To);
            }
        }

        $this->redirect('/perfil/'.$To);

    }
}