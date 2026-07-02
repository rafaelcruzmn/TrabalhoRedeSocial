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
        return $this->con->lastInsertId();
    }

    public function getTodosPosts()
    {
        $sql = $this->con->prepare(
            "SELECT p.*, u.usuario as nome_autor, u.idusuario as autor_id
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

    public function countPostsByUsuario($idUsuario)
    {
        $sql = $this->con->prepare("SELECT COUNT(*) as total FROM Post WHERE usuario_idusuario = :idUsuario");
        $sql->bindValue(':idUsuario', $idUsuario);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    public function getPostsByUsuarioId($idUsuario)
    {
        $sql = $this->con->prepare(
            "SELECT p.*, u.usuario as nome_autor, u.idusuario as autor_id
             FROM Post p
             JOIN Usuario u ON p.usuario_idusuario = u.idusuario
             WHERE p.usuario_idusuario = :idUsuario
             ORDER BY p.datapost DESC"
        );
        $sql->bindValue(':idUsuario', $idUsuario);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluirPost($idPost, $idUsuario)
    {
        // Primeiro, buscar o caminho da imagem para poder excluí-la do servidor
        $sqlSelect = $this->con->prepare("SELECT imagem FROM Post WHERE idpost = :idPost AND usuario_idusuario = :idUsuario");
        $sqlSelect->bindValue(':idPost', $idPost);
        $sqlSelect->bindValue(':idUsuario', $idUsuario);
        $sqlSelect->execute();
        $resultado = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        if ($resultado && !empty($resultado['imagem'])) {
            // O caminho no BD é relativo à pasta 'views', ex: 'imagens/posts/1.jpg'
            // Para excluir, precisamos do caminho a partir do DAO (que está em 'dao/').
            $caminhoArquivo = __DIR__ . '/../views/' . $resultado['imagem'];
            if (file_exists($caminhoArquivo)) {
                unlink($caminhoArquivo);
            }
        }

        // Agora, excluir o post do banco de dados
        $sql = $this->con->prepare(
            "DELETE FROM Post WHERE idpost = :idPost AND usuario_idusuario = :idUsuario"
        );
        $sql->bindValue(':idPost', $idPost);
        $sql->bindValue(':idUsuario', $idUsuario);
        return $sql->execute();
    }

    public function atualizarCaminhoImagem($idPost, $caminhoImagem) {
        $sql = $this->con->prepare("UPDATE Post SET imagem = :imagem WHERE idpost = :idPost");
        $sql->bindValue(':imagem', $caminhoImagem);
        $sql->bindValue(':idPost', $idPost);
        return $sql->execute();
    }
}
?>