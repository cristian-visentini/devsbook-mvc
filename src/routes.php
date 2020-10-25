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

$router->get('/perfil/{id}/fotos', 'ProfileController@photos');
$router->get('/perfil/{id}/follow', 'ProfileController@Follow');
$router->get('/perfil/{id}', 'ProfileController@index');
$router->get('/perfil', 'ProfileController@index');

$router->get('/amigos', 'ProfileController@friends');

$router->get('/fotos', 'ProfileController@photos');

$router->get('/pesquisa', 'SearchController@index');

$router->get('/configuration', 'ConfigController@index');
$router->post('/configuration', 'ConfigController@ConfigAction');

$router->get('/sair', 'LoginController@Logout');

//$router->get('/pesquisa);
//$router->get('/perfil);
//$router->get('/sair);
//$router->get('/amigos);
//$router->get('/fotos;
//$router->get('/config);