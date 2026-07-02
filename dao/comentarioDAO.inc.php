<?php
require_once 'conexao.inc.php';
require_once '../classes/comentario.inc.php';

class ComentarioDAO
{
    private $con;

    function __construct()
    {
        $conexao = new Conexao();
        $this->con = $conexao->getConexao();
    }

    public function countComentariosByUsuario($idUsuario)
    {
        $sql = $this->con->prepare("SELECT COUNT(*) as total FROM comentario WHERE usuario_idusuario = :idUsuario");
        $sql->bindValue(':idUsuario', $idUsuario);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    public function getComentariosByPostId($idPost)
    {
        $sql = $this->con->prepare(
            "SELECT c.*, u.usuario as nome_autor 
             FROM comentario c
             JOIN usuario u ON c.usuario_idusuario = u.idusuario
             WHERE c.post_idpost = :idPost
             ORDER BY c.datacoment ASC"
        );
        $sql->bindValue(':idPost', $idPost);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inserirComentario(Comentario $comentario)
    {
        $sql = $this->con->prepare("INSERT INTO comentario (texto, post_idpost, usuario_idusuario) VALUES (:texto, :idPost, :idUsuario)");
        $sql->bindValue(':texto', $comentario->getTexto());
        $sql->bindValue(':idPost', $comentario->getPost_idpost());
        $sql->bindValue(':idUsuario', $comentario->getUsuario_idusuario());
        $sql->execute();
    }

    public function getPostsComentadosPeloUsuario($idUsuario)
    {
        $sql = $this->con->prepare(
            "SELECT p.*, u.usuario as nome_autor, u.idusuario as autor_id
             FROM comentario c
             JOIN post p ON c.post_idpost = p.idpost
             JOIN usuario u ON p.usuario_idusuario = u.idusuario
             WHERE c.usuario_idusuario = :idUsuario
             GROUP BY p.idpost
             ORDER BY MAX(c.datacoment) DESC"
        );
        $sql->bindValue(':idUsuario', $idUsuario);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>