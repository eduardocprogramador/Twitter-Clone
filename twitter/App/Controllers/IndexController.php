<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action{
    
    public function index(){
        $this->render('index');
    }
    public function home(){
        session_start();
        if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
            $this->render('home');
        }else{
            header('Location: /login?erro=2');
        }
    }
    
}
?>