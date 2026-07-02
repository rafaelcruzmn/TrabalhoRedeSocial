<?php
require_once 'conexao.inc.php';

class LikeDAO
{
    private $con;

    function __construct()
    {
        $conexao = new Conexao();
        $this->con = $conexao->getConexao();
    }

    public function contarLikes($idPost)
    {
        $sql = $this->con->prepare("SELECT COUNT(*) as total FROM likes WHERE post_idpost = :idPost");
        $sql->bindValue(':idPost', $idPost);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    public function verificarLike($idUsuario, $idPost)
    {
        $sql = $this->con->prepare("SELECT idlikes FROM likes WHERE usuario_idusuario = :idUsuario AND post_idpost = :idPost");
        $sql->bindValue(':idUsuario', $idUsuario);
        $sql->bindValue(':idPost', $idPost);
        $sql->execute();
        return $sql->rowCount() > 0;
    }

    public function darLike($idUsuario, $idPost)
    {
        $sql = $this->con->prepare("INSERT INTO likes (usuario_idusuario, post_idpost) VALUES (:idUsuario, :idPost)");
        $sql->bindValue(':idUsuario', $idUsuario);
        $sql->bindValue(':idPost', $idPost);
        return $sql->execute();
    }

    public function tirarLike($idUsuario, $idPost)
    {
        $sql = $this->con->prepare("DELETE FROM likes WHERE usuario_idusuario = :idUsuario AND post_idpost = :idPost");
        $sql->bindValue(':idUsuario', $idUsuario);
        $sql->bindValue(':idPost', $idPost);
        return $sql->execute();
    }
}
?>