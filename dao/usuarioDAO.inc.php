<?php
require_once 'conexao.inc.php';
require_once '../classes/usuario.inc.php';

class UsuarioDao{
    private $con;

    function __construct(){
        $conexao = new Conexao();
        $this->con = $conexao->getConexao();
    }

    public function autenticar($email, $senha) {
        $sql = $this->con->prepare("SELECT * FROM usuario WHERE email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $registro = $sql->fetch(PDO::FETCH_OBJ);
            
            if(password_verify($senha, $registro->senha)) {
                $usuario = new Usuario(
                    $registro->idusuario,
                    $registro->usuario,
                    $registro->email, 
                    $registro->senha, 
                    $registro->descricao
                );
                
                return $usuario;
            }
        }
        return NULL;
    }

    public function inserirUsuario(Usuario $usuario){
        $sql = $this->con->prepare("INSERT INTO usuario (usuario, email, senha, descricao) VALUES (:nom, :email, :senha, :desc)");
        $sql->bindValue(':nom', $usuario->getNome());
        $sql->bindValue(':email', $usuario->getEmail());
        $sql->bindValue(':senha', password_hash($usuario->getSenha(), PASSWORD_BCRYPT));
        $sql->bindValue(':desc', NULL);
        $sql->execute();

        return $this->con->lastInsertId();
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