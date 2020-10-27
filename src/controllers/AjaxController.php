<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use src\handlers\PostHandler;

class AjaxController extends Controller {

    private $LoggedUser;

    public function __construct(){
        echo "chegou no construct";
        exit;
        $this->LoggedUser = UserHandler::CheckLogin();

        if($this->LoggedUser === false){
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Usuario Não Logado']);
            exit;
        }

    }

    public function like($atts) {
        echo "chegou no like";
        exit;
        $Id = $atts['id'];

       

        if(PostHandler::IsLiked($Id, $this->LoggedUser->Id)){
            PostHandler::DeleteLike($Id, $this->LoggedUser->Id);
        }else{
            PostHandler::AddLike($Id, $this->LoggedUser->Id);
        }

    }
}