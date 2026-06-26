<?php

    public Class Comentario{
        private Usuario $usuario;
        private Post $post;
        private $comentario_id;
        private $textoComentario;
        private $data_comentario;

    public __construct(){}

    public function setComentario($usuario, $post, $textoComentario, $data_comentario)
    {
        $this->usuario = $usuario;
        $this->post = $post;
        $this->textoComentario = $textoComentario;
        $this->data_comentario = strtotime($data_comentario);
    }

    public function getComentario_id()
    {
        return $this->comentario_id;
    }

    public function setComentario_id($pId)
    {
        return $this->comentario_id = $pId;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($pUsuario)
    {
        return $this->usuario = $pUsuario;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost($pPost)
    {
        return $this->post = $pPost;
    }

    public function getTextoComentario()
    {
        return $this->textoComentario;
    }

    public function setTextoComentario($pTextoComentario)
    {
        return $this->textoComentario = $pTextoComentario;
    }

    public function getData_comentario()
    {
        return $this->data_comentario;
    }

    public function setData_comentario($pData_comentario)
    {
        return $this->data_comentario = strtotime($pData_comentario);
    }
}
?>
