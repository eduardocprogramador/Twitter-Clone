<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action{
    
    public function login(){
        $this->render('login');
    }
    public function criar_conta(){
        $this->render('criar_conta');
    }
    public function esqueceu_senha(){
        $this->render('esqueceu_senha');
    }
    public function nova_senha(){
        $this->render('nova_senha');
    }
    public function login_post(){
        ob_start();
        $user=Container::getModel('Usuarios');
        $user->__set('email',$_POST['email']);
        $user->__set('senha',$_POST['senha']);
        $retorno=$user->logar();
        $user->__set('id',$retorno['id']);
        $user->__set('username',$retorno['username']);
        if(!empty($user->__get('id'))){
            session_start();
            $_SESSION['id']=$user->__get('id');
            $_SESSION['username']=$user->__get('username');
            header('Location: /home');
        }else{
            $this->view->erro=1;
            $this->view->email=$_POST['email'];
            $this->view->senha=$_POST['senha'];
            $this->render('login');
        }
        exit();
    }
    public function criar_conta_post(){
        ob_start();
        $user=Container::getModel('Usuarios');
        $user->__set('username',$_POST['username']);
        $user->__set('email',$_POST['email']);
        $user->__set('senha',$_POST['senha']);
        if($user->validarCadastro() && count($user->getUsername()) == 0 && count($user->getEmail()) == 0 && $_POST['senha'] == $_POST['confirmar_senha']){
            $user->salvar();
            header('Location: /login?conta_criada=1');
        }else{
            $this->view->username=$_POST['username'];
            $this->view->email=$_POST['email'];
            $this->view->senha=$_POST['senha'];
            $this->view->confirmar_senha=$_POST['confirmar_senha'];
            if(count($user->getUsername()) > 0){
                $this->view->erro=1;
                $this->render('criar_conta');
            }else if(count($user->getEmail()) > 0){
                $this->view->erro=2;
                $this->render('criar_conta');
            }else if(!($user->validarCadastro())){
                $this->view->erro=3;
                $this->render('criar_conta');
            }else{
                $this->view->erro=4;
                $this->render('criar_conta');
            }
        }
        exit();
    }
    public function sair(){
        session_start();
        session_destroy();
        header('Location: /login');
    }
    public function enviar_email(){
        ob_start();
        $user=Container::getModel('Usuarios');
        $user->__set('email',$_POST['email']);
        if(count($user->getEmail()) > 0){
            $idArray=$user->getId();
            $id=$idArray['id'];
            require 'processa_envio.php';
            header('Location: /esqueceu_senha?mensagem_enviada=1');
        }else{
            $this->view->erro=1;
            $this->view->email=$_POST['email'];
            $this->render('esqueceu_senha');
        }
        exit();
    }
    public function nova_senha_post(){
        ob_start();
        $user=Container::getModel('Usuarios');
        $user->__set('id',$_POST['id']);
        $user->__set('senha',$_POST['senha']);
        if($user->validarCadastro() && $_POST['senha'] == $_POST['confirmar_senha']){
            $user->redefinirSenha();
            header('Location: /login?senha_alterada=1');
        }else{
            $this->view->senha=$_POST['senha'];
            $this->view->confirmar_senha=$_POST['confirmar_senha'];
            $this->view->id=$_POST['id'];
            if(!($user->validarCadastro())){
                $this->view->erro=1;
                $this->render('nova_senha');
            }else{
                $this->view->erro=2;
                $this->render('nova_senha');
            }
        }
    }
}
?>