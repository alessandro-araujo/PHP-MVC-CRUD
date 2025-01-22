<?php
namespace application\models;
require_once __DIR__ . '/../../vendor/autoload.php';

date_default_timezone_set('America/Sao_Paulo');

use DateTime;
use PDO;
use PDOException;

const BD_SERVER = 'localhost';
const BD_USUARIO = 'root';
const BD_SENHA = '';
const BD_BANCO = 'dbcorretores';
const DATA_SOURCE = 'mysql:host=' . BD_SERVER . ';dbname=' . BD_BANCO . ';charset=utf8mb4';


class modelsConnection
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->connection();
    }

    private function connection(): void
    {
        try {
            $setPDO = new PDO(DATA_SOURCE, BD_USUARIO, BD_SENHA);
            $setPDO->setAttribute(PDO::ATTR_TIMEOUT, 300);
            $this->pdo = $setPDO;
        } catch (PDOException $Error) {
            if ($Error->getCode() == 2006) {
                $setPDO = new PDO(DATA_SOURCE, BD_USUARIO, BD_SENHA);
                $this->pdo = $setPDO;
            } else {
                print("<span>ErrorLog PDOException: " . $Error->getMessage() . "</span>");
            }
        }
    }
    
    public function postClients(string $name, int $cpf, int $creci): array
    {
        try {
            $postClient = $this->pdo->prepare('INSERT INTO corretores (name, cpf, creci) VALUES (:name, :cpf, :creci);');
            $postClient->bindParam(':name', $name);
            $postClient->bindParam(':cpf', $cpf);
            $postClient->bindParam(':creci', $creci);
            if ($postClient->execute()) {
                return array("status" => true, "message" => "Cadastrado com sucesso");
            } else {
                return array("status" => false, "message" => "Falha ao registrar");
            }
        } catch (PDOException $Error) {
            return array("status" => false, "message" => $Error->getMessage());
        } finally {
            $postClient = null;
        }
    }



    public function getClient(int $idName): array
    {
        try {
            $consultClient = $this->pdo->prepare("SELECT * FROM corretores WHERE id = (:id);");
            $consultClient->bindParam(':id', $idName);
            $consultClient->execute();
            $resultConsultClient = $consultClient->fetch(PDO::FETCH_ASSOC);
            if ($resultConsultClient) {
                return array("status" => true, "client" => $resultConsultClient);
            } else {
                return array("status" => false, "message" => "Não encontrado");
            }
        } catch (PDOException $Error) {
            return array("status" => false, "message" => $Error->getMessage());
        } finally {
            $consultClient = null;
        }
    }

    public function getAllClients(): array
    {
        try {
            $consultClient = $this->pdo->prepare("SELECT * FROM corretores");
            $consultClient->execute();
            $resultConsultClient = $consultClient->fetchAll(PDO::FETCH_ASSOC);
            if ($resultConsultClient) {
                return array("status" => true, "client" => $resultConsultClient);
            } else {
                return array("status" => false, "message" => "Não encontrado");
            }
        } catch (PDOException $Error) {
            return array("status" => false, "message" => $Error->getMessage());
        } finally {
            $consultClient = null;
        }
    }


    public function putClient(int $idName, string $name, int $cpf, int $creci): array
    {
        try {
            $putClient = $this->pdo->prepare("UPDATE corretores SET name = :name, cpf = :cpf, creci = :creci
                                                        WHERE id = (:id);");
            $putClient->bindParam(":name", $name);
            $putClient->bindParam(":cpf", $cpf);
            $putClient->bindParam(":creci", $creci);
            $putClient->bindParam(":id", $idName, PDO::PARAM_INT);
            if ($putClient->execute() && $putClient->rowCount() > 0) {
                return array("status" => true, "message" => 'Atualizado com sucesso');
            } else {
                return array("status" => false, "message" => 'Falha ao atualizar');
            }
        } catch (PDOException $Error) {
            return array("status" => false, "message" => $Error->getMessage());
        } finally {
            $putClient = null;
        }
    }

    public function delClient(int $idName): array
    {
        try {
            $delClient = $this->pdo->prepare("DELETE FROM corretores WHERE id = (:id);");
            $delClient->bindParam(':id', $idName, PDO::PARAM_INT);
            if ($delClient->execute() && $delClient->rowCount() > 0) {
                return array("status" => true, "message" => "Excluído com sucesso");
            } else {
                return array("status" => false, "message" => "Falha ao excluir");
            }
        } catch (PDOException $Error) {
            return array("status" => false, "message" => $Error->getMessage());
        } finally {
            $delClient = null;
        }
    }
}
