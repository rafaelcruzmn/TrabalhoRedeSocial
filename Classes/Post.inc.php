<?php
class Post
{
    private $idpost;
    private $titulo;
    private $descricao;
    private $texto;
    private $datapost;
    private $usuario_idusuario;
    private $imagem;

    public function __construct($idpost, $titulo, $descricao, $texto, $datapost, $usuario_idusuario, $imagem = null)
    {
        $this->idpost = $idpost;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->texto = $texto;
        $this->datapost = $datapost;
        $this->usuario_idusuario = $usuario_idusuario;
        $this->imagem = $imagem;
    }

    public function getIdpost()
    {
        return $this->idpost;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getTexto()
    {
        return $this->texto;
    }

    public function getDatapost()
    {
        return $this->datapost;
    }

    public function getUsuario_idusuario()
    {
        return $this->usuario_idusuario;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function setIdpost($idpost)
    {
        $this->idpost = $idpost;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function setTexto($texto)
    {
        $this->texto = $texto;
    }

    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }
}
?>