<?php

class Usuario{
    private $usuario_id;
    private $nome;
    private $email;
    private $senha;
    private $descricaoUsuario;

    function __construct(){
       
    }
    
    function setUsuario($nome, $email, $senha, $descricaoUsuario)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->descricaoUsuario = $descricaoUsuario;
    }

    public function getUsuario_id()
    {
        return $this->usuario_id;
    }

    public function setUsuario_id($Id)
    {
        return $this->usuario_id = $Id;
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