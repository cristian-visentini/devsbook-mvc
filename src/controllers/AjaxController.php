<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use src\handlers\PostHandler;

class AjaxController extends Controller {

    private $LoggedUser;

    public function __construct(){
        //router nao esta chegando no AjaxController, nao esta iniciando nem mesmo o construct
        $this->LoggedUser = UserHandler::CheckLogin();

        if($this->LoggedUser === false){
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Usuario Não Logado']);
            exit;
        }

    }

    public function like($atts) {
        //$router->get não esta enviando para o metodo Like
        $Id = $atts['id'];

       

        if(PostHandler::IsLiked($Id, $this->LoggedUser->Id)){
            PostHandler::DeleteLike($Id, $this->LoggedUser->Id);
        }else{
            PostHandler::AddLike($Id, $this->LoggedUser->Id);
        }

    }
}