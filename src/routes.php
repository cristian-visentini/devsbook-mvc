<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/login', 'LoginController@signin');
$router->post('/login', 'LoginController@signinAction');

$router->get('/cadastro', 'LoginController@singnup');
$router->post('/cadastro', 'LoginController@singnupAction');

$router->post('/post/new', 'PostController@new');

$router->get('/perfil/{id}/amigos', 'ProfileController@friends');

$router->get('/perfil/{id}/follow', 'ProfileController@Follow');
$router->get('/perfil/{id}', 'ProfileController@index');
$router->get('/perfil', 'ProfileController@index');

$router->get('/amigos', 'ProfileController@friends');

$router->get('/sair', 'LoginController@Logout');

//$router->get('/pesquisa);
//$router->get('/perfil);
//$router->get('/sair);
//$router->get('/amigos);
//$router->get('/fotos;
//$router->get('/config);