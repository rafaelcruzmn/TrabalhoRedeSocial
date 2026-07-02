<?php

class Usuario{
    private $idUsuario;
    private $nome;
    private $email;
    private $senha;
    private $descricaoUsuario;

    function __construct($idUsuario, $nome, $email, $senha, $descricaoUsuario){
        $this->idUsuario = $idUsuario;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->descricaoUsuario = $descricaoUsuario;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($Id)
    {
        return $this->idUsuario = $Id;
    }
    
    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($pNome)
    {
        return $this->nome = $pNome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($pEmail)
    {
        return $this->email = $pEmail;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($pSenha)
    {
        return $this->senha = $pSenha;
    }

    public function getDescricaoUsuario()
    {
        return $this->descricaoUsuario;
    }

    public function setDescricaoUsuario($pDescricaoUsuario)
    {
        return $this->descricaoUsuario = $pDescricaoUsuario;
    }
}
?>