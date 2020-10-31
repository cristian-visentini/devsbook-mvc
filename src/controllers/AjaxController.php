<?php

namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use src\handlers\PostHandler;

class AjaxController extends Controller
{

    private $LoggedUser;

    public function __construct()
    {
        $this->LoggedUser = UserHandler::CheckLogin();

        if ($this->LoggedUser === false) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Usuario Não Logado']);
            exit;
        }
    }

    public function like($atts)
    {
        $Id = $atts['id'];

        if (PostHandler::IsLiked($Id, $this->LoggedUser->Id)) {
            PostHandler::DeleteLike($Id, $this->LoggedUser->Id);
        } else {
            PostHandler::AddLike($Id, $this->LoggedUser->Id);
        }
    }

    public function comment()
    {
        $Array = ['error' => ''];
        $Id = filter_input(INPUT_POST, 'id');
        $Txt = filter_input(INPUT_POST, 'txt');


        if ($Id && $Txt) {
            PostHandler::AddComent($Id, $Txt, $this->LoggedUser->Id);

            $Array['link'] = '/perfil/' . $this->LoggedUser->Id;
            $Array['avatar'] = '/media/avatars/' . $this->LoggedUser->Avatar;
            $Array['name'] = $this->LoggedUser->Name;
            $Array['body'] = $Txt;
        }

        header("Content-Type: application/json");
        echo json_encode($Array);
        exit;
    }

    public function upload()
    {
        $Array = ['error' => ''];

        if (isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])) {

            $Photo = $_FILES['photo'];
            $MaxWidth = 800;
            $MaxHeight = 800;

            if (in_array($Photo['type'], ['image/png', 'image/jpeg', 'image/jpg'])) {
                list($WidthOrig, $HeightOrig) = getimagesize($Photo['tmp_name']);
                $Ratio = $WidthOrig / $HeightOrig;


                $NewWidth = $MaxWidth;
                $NewHeight = $MaxHeight;
                $RatioMax = $MaxWidth / $MaxHeight;

                if ($RatioMax > $Ratio) {
                    $NewWidth = $NewHeight * $Ratio;
                } else {
                    $NewHeight = $NewWidth / $Ratio;
                }

                $FinalImage = imagecreatetruecolor($NewWidth, $NewHeight);

                switch ($Photo['type']) {
                    case 'image/png':
                        $Image = imagecreatefrompng($Photo['tmp_name']);
                        break;
                    case 'image/jpg':
                    case 'image/jpeg':
                        $Image = imagecreatefromjpeg($Photo['tmp_name']);
                    break;
                }

                imagecopyresampled(
                    $FinalImage, $Image,
                    0, 0, 0, 0,
                    $NewWidth, $NewHeight,
                    $WidthOrig, $HeightOrig
                );

                $PhotoName = md5(time().rand(0, 999)).'.jpg';
                imagejpeg($FinalImage, 'media/uploads/'.$PhotoName);

                PostHandler::AddPost($this->LoggedUser->Id, 'photo', $PhotoName);

            }
        } else {
            $Array['error'] = 'Nenhuma imagem enviada';
        }

        header("Content-Type: application/json");
        echo json_encode($Array);
        exit;
    }
}
