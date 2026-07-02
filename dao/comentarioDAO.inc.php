<?php
require_once 'conexao.inc.php';

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
}
?>