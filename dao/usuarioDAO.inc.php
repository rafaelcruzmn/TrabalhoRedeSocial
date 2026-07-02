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

    public function getUsuarioById($id) {
        $sql = $this->con->prepare("SELECT * FROM usuario WHERE idusuario = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $registro = $sql->fetch(PDO::FETCH_OBJ);
            
            $usuario = new Usuario(
                $registro->idusuario,
                $registro->usuario,
                $registro->email, 
                $registro->senha, 
                $registro->descricao
            );
            
            return $usuario;
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

    public function atualizarUsuario(Usuario $usuario) {
        try {
            // Note que a coluna para nome é 'usuario' e para descrição é 'descricao' no seu banco
            $sql = $this->con->prepare("UPDATE usuario SET usuario = :nome, descricao = :descricao WHERE idusuario = :id");
            
            $sql->bindValue(':nome', $usuario->getNome());
            $sql->bindValue(':descricao', $usuario->getDescricaoUsuario());
            $sql->bindValue(':id', $usuario->getIdUsuario());
            
            return $sql->execute();
        } catch (PDOException $e) {
            die("Erro ao atualizar usuário: " . $e->getMessage());
        }
    }
}