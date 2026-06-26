<?php
require_once 'conexao.inc.php';
require_once '../classes/Usuario.inc.php';

class UsuarioDao{
    private $con;

    function __construct(){
        $conexao = new Conexao();
        $this->con = $conexao->getConexao();
    }

    public function autenticar($email, $senha){
        $sql = $this->con->prepare("select * from Usuario where Email = :email and Senha = :senha");
        $sql->bindValue(':email', $email);
        $sql->bindValue(':senha', $senha);
        $sql->execute();

        if($sql->rowCount() > 0){
            $registro = $sql->fetch(PDO::FETCH_OBJ);
            $usuario = new Usuario();
            $usuario->setUsuario_id($registro->idUsuario);
            $usuario->setNome($registro->Usuario);
            $usuario->setEmail($registro->Email);
            return $usuario;
        }
        else{
            return NULL;
        }
    }

    public function inserirUsuario(Usuario $usuario){
        $sql = $this->con->prepare("insert into Usuario (Usuario, Email, Senha) values (:nom, :email, :senha)");
        $sql->bindValue(':nom', $usuario->getNome());
        $sql->bindValue(':email', $usuario->getEmail());
        $sql->bindValue(':senha', $usuario->getSenha());
        $sql->execute();
    }

    public function getDescricaoUsuarioDAO($id){
        $sql = $this->con->prepare("select Descricao from Usuario where idUsuario = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $registro = $sql->fetch(PDO::FETCH_OBJ);
            return $registro->Descricao;
        }
        else{
            return NULL;
        }
    }

    public function atualizarDescricaoUsuario($id, $descricao){
        $sql = $this->con->prepare("update Usuario set Descricao = :desc where idUsuario = :id");
        $sql->bindValue(':desc', $descricao);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
}