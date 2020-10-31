<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use src\handlers\PostHandler;

class AjaxController extends Controller {

    private $LoggedUser;

    public function __construct(){
        $this->LoggedUser = UserHandler::CheckLogin();

        if($this->LoggedUser === false){
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Usuario Não Logado']);
            exit;
        }

    }

    public function like($atts) {
        $Id = $atts['id'];

        if(PostHandler::IsLiked($Id, $this->LoggedUser->Id)){
            PostHandler::DeleteLike($Id, $this->LoggedUser->Id);
        }else{
            PostHandler::AddLike($Id, $this->LoggedUser->Id);
        }

    }

    public function comment(){
        $Array = ['error' => ''];
        $Id = filter_input(INPUT_POST, 'id');
        $Txt = filter_input(INPUT_POST, 'txt');


        if($Id && $Txt){
            PostHandler::AddComent($Id, $Txt, $this->LoggedUser->Id);

            $Array['link'] = '/perfil/'.$this->LoggedUser->Id;
            $Array['avatar'] = '/media/avatars/'.$this->LoggedUser->Avatar;
            $Array['name'] = $this->LoggedUser->Name;
            $Array['body'] = $Txt;
        }

        header("Content-Type: application/json");
        echo json_encode($Array);
        exit;
    }
}