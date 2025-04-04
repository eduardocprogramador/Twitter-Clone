<?php
namespace App;
use MF\Init\Bootstrap;
use App\Connection;

class Route extends Bootstrap{

    protected function initRoutes(){
        $routes['inicio']=array(
            'route' => '/',
            'controller' => 'indexController',
            'action' => 'index'
        );
        $routes['login']=array(
            'route' => '/login',
            'controller' => 'AuthController',
            'action' => 'login'
        );
        $routes['login_post']=array(
            'route' => '/login_post',
            'controller' => 'AuthController',
            'action' => 'login_post'
        );
        $routes['criar_conta']=array(
            'route' => '/criar_conta',
            'controller' => 'AuthController',
            'action' => 'criar_conta'
        );
        $routes['criar_conta_post']=array(
            'route' => '/criar_conta_post',
            'controller' => 'AuthController',
            'action' => 'criar_conta_post'
        );
        $routes['esqueceu_senha']=array(
            'route' => '/esqueceu_senha',
            'controller' => 'AuthController',
            'action' => 'esqueceu_senha'
        );
        $routes['enviar_email']=array(
            'route' => '/enviar_email',
            'controller' => 'AuthController',
            'action' => 'enviar_email'
        );
        $routes['nova_senha']=array(
            'route' => '/nova_senha',
            'controller' => 'AuthController',
            'action' => 'nova_senha'
        );
        $routes['nova_senha_post']=array(
            'route' => '/nova_senha_post',
            'controller' => 'AuthController',
            'action' => 'nova_senha_post'
        );
        $routes['home']=array(
            'route' => '/home',
            'controller' => 'indexController',
            'action' => 'home'
        );
        $routes['sair']=array(
            'route' => '/sair',
            'controller' => 'AuthController',
            'action' => 'sair'
        );
        $this->setRoutes($routes);
    }

}
?>