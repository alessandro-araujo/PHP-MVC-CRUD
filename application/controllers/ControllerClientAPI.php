<?php

namespace application\controllers;
require_once __DIR__ . '/../../vendor/autoload.php';

use application\models\ClientModel;

class ControllerClientAPI
{
    private ClientModel $user;
    private int $idUser;

    public function __construct($idUser = 0)
    {
        $this->user = new ClientModel();
        $this->idUser = $idUser;
    }

    public function returnAllUsers()
    {
        $response = $this->user->getAll();
        return $response;     
    }
    
    public function createlUser($name, $cpf, $creci)
    {
        $responsePost = $this->user->registerClient($name, $cpf, $creci);
        return $responsePost;
    }

    public function getUser($idName)
    {
        $responseGet = $this->user->returnClient($idName);
        return $responseGet;
    }

    public function updateUser($idName, $name, $cpf, $creci)
    {
        $responseUpdate = $this->user->updateClient($idName, $name, $cpf, $creci);
        return $responseUpdate;
    }
    
    public function deletelUser($idName)
    {
        $responseDel = $this->user->deleteUser($idName);
        return $responseDel;
    }
}