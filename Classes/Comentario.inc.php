<?php

class Comentario
{
    private $idcomentario;
    private $texto;
    private $datacoment;
    private $post_idpost;
    private $usuario_idusuario;

    public function __construct($idcomentario, $texto, $datacoment, $post_idpost, $usuario_idusuario)
    {
        $this->idcomentario = $idcomentario;
        $this->texto = $texto;
        $this->datacoment = $datacoment;
        $this->post_idpost = $post_idpost;
        $this->usuario_idusuario = $usuario_idusuario;
    }

    // Getters
    public function getIdcomentario()
    {
        return $this->idcomentario;
    }

    public function getTexto()
    {
        return $this->texto;
    }

    public function getDatacoment()
    {
        return $this->datacoment;
    }

    public function getPost_idpost()
    {
        return $this->post_idpost;
    }

    public function getUsuario_idusuario()
    {
        return $this->usuario_idusuario;
    }

    // Setters
    public function setIdcomentario($idcomentario)
    {
        $this->idcomentario = $idcomentario;
    }

    public function setTexto($texto)
    {
        $this->texto = $texto;
    }

    public function setDatacoment($datacoment)
    {
        $this->datacoment = $datacoment;
    }

    public function setPost_idpost($post_idpost)
    {
        $this->post_idpost = $post_idpost;
    }

    public function setUsuario_idusuario($usuario_idusuario)
    {
        $this->usuario_idusuario = $usuario_idusuario;
    }
}
?>
