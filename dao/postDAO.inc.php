<?php
require_once 'conexao.inc.php';
require_once '../classes/post.inc.php';

class PostDAO
{
    private $con;

    function __construct()
    {
        $conexao = new Conexao();
        $this->con = $conexao->getConexao();
    }

    public function incluirPost(Post $post)
    {
        $sql = $this->con->prepare("INSERT INTO Post(titulo, descricao, texto, usuario_idusuario) VALUES (:titulo, :descricao, :texto, :usuario_idusuario)");

        $sql->bindValue(':titulo', $post->getTitulo());
        $sql->bindValue(':descricao', $post->getDescricao());
        $sql->bindValue(':texto', $post->getTexto());
        $sql->bindValue(':usuario_idusuario', $post->getUsuario_idusuario());

        $sql->execute();
    }

    public function getTodosPosts()
    {
        $sql = $this->con->prepare(
            "SELECT p.*, u.usuario as nome_autor
             FROM Post p
             JOIN Usuario u ON p.usuario_idusuario = u.idusuario
             ORDER BY p.datapost DESC"
        );
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }
}
?>