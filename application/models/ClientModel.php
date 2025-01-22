<?php
namespace application\models;
require_once __DIR__ . '/../../vendor/autoload.php';

class ClientModel extends modelsConnection
{
    public function getAll(): array
    {
        return $this->getAllClients();
    }

    public function deleteUser($idName): array
    {
        return $this->delClient($idName);
    }

    public function returnClient($idName): array
    {
        return $this->getClient($idName);
    }

    public function updateClient($idName, $name, $cpf, $creci): array
    {
        return $this->putClient($idName, $name, $cpf, $creci);
    }

    public function registerClient($name, $cpf, $creci): array
    {
        return $this->postClients($name, $cpf, $creci);
    }
}