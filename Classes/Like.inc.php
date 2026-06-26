<?php
    public class Like{
        private Usuario $usuario;
        private Post $post;
        private $like_id;
    
    public __construct(){}

    public function setLike($usuario, $post)
    {
        $this->usuario = $usuario;
        $this->post = $post;
    }

    public function getLike_id()
    {
        return $this->like_id;
    }

    public function setLike_id($pId)
    {
        return $this->like_id = $pId;
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
}
?>