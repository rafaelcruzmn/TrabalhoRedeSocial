<?php
    public class Post{
        private Usuario $usuario;
        private $post_id;
        private $titulo;
        private $descricaoPost;
        private $texto;
        private $data_postagem;

    public __construct(){
       
    }

    public function setPost($usuario, $titulo, $descricaoPost, $texto, $data_postagem)
    {
        $this->usuario = $usuario;
        $this->titulo = $titulo;
        $this->descricaoPost = $descricaoPost;
        $this->texto = $texto;
        $this->data_postagem = strtotime($data_postagem);
    }

    public function getPost_id()
    {
        return $this->post_id;
    }

    public function setPost_id($pId)
    {
        return $this->post_id = $pId;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setTitulo($pTitulo)
    {
        return $this->titulo = $pTitulo;
    }

    public function getDescricaoPost()
    {
        return $this->descricaoPost;
    }

    public function setDescricaoPost($pDescricaoPost)
    {
        return $this->descricaoPost = $pDescricaoPost;
    }

    public function getTexto()
    {
        return $this->texto;
    }

    public function setTexto($pTexto)
    {
        return $this->texto = $pTexto;
    }

    public function getData_postagem()
    {
        return $this->data_postagem;
    }

    public function setData_postagem($pData_postagem)
    {
        return $this->data_postagem = strtotime($pData_postagem);
    }
}
?>