<?php


namespace App\DTO;

class LoginDTO {
    private string $login;
    private string $password;

    public function __construct()
    {

    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): LoginDTO
    {
        $this->login = $login;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): LoginDTO
    {
        $this->password = $password;
        return $this;
    }
}