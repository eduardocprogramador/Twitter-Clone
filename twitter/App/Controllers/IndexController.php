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
        $tweet->__set('id_usuario',$_SESSION['id']);
        $tweets=$tweet->buscar_tweets();
        $this->view->tweets=$tweets;
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
    public function quem_seguir(){
        $this->valida_autenticacao();
        $pesquisa=isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
        $users=array();
        $seguindo=array();
        if($pesquisa != ''){
            $user=Container::getModel('Usuarios');
            $user->__set('username', $pesquisa);
            $user->__set('id', $_SESSION['id']);
            $users=$user->buscar_usuarios();
            $user_seguindo=Container::getModel('UsuariosSeguindo');
            $user_seguindo->__set('id', $_SESSION['id']);
            $seguindo=$user_seguindo->buscar_seguindo();
        }
        $this->view->users=$users;
        $this->view->seguindo=$seguindo;
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