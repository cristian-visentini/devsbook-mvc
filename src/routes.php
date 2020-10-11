<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/login', 'LoginController@signin');
$router->post('/login', 'LoginController@signinAction');

$router->get('/cadastro', 'LoginController@singnup');
$router->post('/cadastro', 'LoginController@singnupAction');

$router->post('/post/new', 'PostController@new');

//$router->get('/pesquisa);
//$router->get('/perfil);
//$router->get('/sair);
//$router->get('/amigos);
//$router->get('/fotos;
//$router->get('/config);