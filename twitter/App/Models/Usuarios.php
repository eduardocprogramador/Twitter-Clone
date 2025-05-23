<?php

namespace App\Models;
use MF\Model\Model;

class Usuarios extends Model {
    private $id;
    private $username;
    private $email;
    private $senha;
    
    public function __get($atributo){
        return $this->$atributo;
    }
    public function __set($atributo,$valor){
        $this->$atributo=$valor;
    }

    public function salvar(){
        $query='insert into usuarios(username,email,senha) values(:username,:email,:senha)';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':username',$this->__get('username'));
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->bindValue(':senha',$this->__get('senha')); 
        $stmt->execute();
        return $this;
    }
    public function validar_cadastro(){
        $valido=true;
        if(strlen($this->__get('senha')) < 6){
            $valido=false;
        }
        return $valido;
    }
    public function getUsername(){
        $query='select username from usuarios where username = :username';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':username',$this->__get('username'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getEmail(){
        $query='select email from usuarios where email = :email';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getId(){
        $query='select id from usuarios where email = :email';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function logar(){
        $query='select id,username,email from usuarios where email = :email and senha = :senha';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->bindValue(':senha',$this->__get('senha')); 
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function redefinir_senha(){
        $query='update usuarios set senha = :senha where id = :id';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':senha',$this->__get('senha')); 
        $stmt->bindValue(':id',$this->__get('id')); 
        $stmt->execute();
        return $this;
    }
    public function buscar_usuarios(){
        $query='select id,username,email from usuarios where username like :username and id != :id_usuario';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':username','%'.$this->__get('username').'%');
        $stmt->bindValue(':id_usuario',$this->__get('id')); 
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function total_tweets(){
        $query='select count(*) as total_tweets from tweets where id_usuario = :id_usuario';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':id_usuario',$this->__get('id')); 
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function total_seguindo(){
        $query='select count(*) as total_seguindo from usuarios_seguindo where id_usuario = :id_usuario';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':id_usuario',$this->__get('id')); 
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function total_seguidores(){
        $query='select count(*) as total_seguidores from usuarios_seguindo where id_usuario_seguindo = :id_usuario';
        $stmt=$this->db->prepare($query);
        $stmt->bindValue(':id_usuario',$this->__get('id')); 
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

?>

