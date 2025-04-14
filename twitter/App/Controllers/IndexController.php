<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action{
    public function valida_autenticacao(){
        session_start();
        if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
            header('Location: /login?erro=2');
        }
    }
    public function index(){
        $this->valida_autenticacao();
        $tweet=Container::getModel('Tweet');
        $tweet->__set('id_usuario', $_SESSION['id']);
        $total_registros_pagina=10;
        $pagina=isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        $deslocamento=($pagina-1)*$total_registros_pagina;
        $total_meus_tweets=$tweet->total_meus_tweets();
        $this->view->pagina_ativa=$pagina;
        $this->view->total_paginas=ceil($total_meus_tweets['total']/$total_registros_pagina);
        $tweets=$tweet->buscar_meus_tweets($total_registros_pagina,$deslocamento);
        $this->view->tweets=$tweets;
        $user=Container::getModel('Usuarios');
        $user->__set('id', $_SESSION['id']);
        $this->view->total_tweets=$user->total_tweets()['total_tweets'];
        $this->view->total_seguindo=$user->total_seguindo()['total_seguindo'];
        $this->view->total_seguidores=$user->total_seguidores()['total_seguidores'];
        $this->render('index');
    }
    public function tweet(){
        $this->valida_autenticacao();
        $tweet=Container::getModel('Tweet');
        $tweet->__set('tweet',$_POST['tweet']);
        $tweet->__set('id_usuario',$_SESSION['id']);
        $tweet->salvar();
        header('Location: /');
    }
    public function remover(){
        $tweet=Container::getModel('Tweet');
        $tweet->__set('id',$_GET['id']);
        $tweet->remover();
        header('Location: /');
    }
    public function quem_seguir(){
        $this->valida_autenticacao();
        $pesquisa=isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
        $users=array();
        $seguindo=array();
        $user=Container::getModel('Usuarios');
        $user->__set('id', $_SESSION['id']);
        if($pesquisa != ''){
            $user->__set('username', $pesquisa);
            $users=$user->buscar_usuarios();
            $user_seguindo=Container::getModel('UsuariosSeguindo');
            $user_seguindo->__set('id', $_SESSION['id']);
            $seguindo=$user_seguindo->buscar_seguindo();
        }
        $this->view->users=$users;
        $this->view->seguindo=$seguindo;
        $this->view->total_tweets=$user->total_tweets()['total_tweets'];
        $this->view->total_seguindo=$user->total_seguindo()['total_seguindo'];
        $this->view->total_seguidores=$user->total_seguidores()['total_seguidores'];
        $this->render('quem_seguir');
    }
    public function seguir(){
        $this->valida_autenticacao();
        $user=Container::getModel('UsuariosSeguindo');
        $user->__set('id_usuario', $_SESSION['id']);
        $user->__set('id_usuario_seguindo', $_GET['id']);
        $user->seguir();
        header('Location: /quem_seguir?pesquisa='.$_GET['pesquisa']);
    }
    public function deixar_seguir(){
        $this->valida_autenticacao();
        $user=Container::getModel('UsuariosSeguindo');
        $user->__set('id_usuario', $_SESSION['id']);
        $user->__set('id_usuario_seguindo', $_GET['id']);
        $user->deixar_seguir();
        header('Location: /quem_seguir?pesquisa='.$_GET['pesquisa']);
    }
}
?>