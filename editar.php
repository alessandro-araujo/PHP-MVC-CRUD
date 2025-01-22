<?php
    require_once __DIR__ . "/vendor/autoload.php";

    use application\controllers\ControllerClientAPI;
    $objectClients = new ControllerClientAPI();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="container text-center py-4">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col">
                    <h1>Alterar Corretor</h1>
                </div>
            </div>
            
           <!-- Form Section -->
            <div class="row mb-4">
                <div class="col">
                <form action="" method="POST">
                        <!-- Inputs alinhados lado a lado -->
                         <?php
                            $idCadastro = $_REQUEST['id'];
                            $clientsData = $objectClients->getUser($idCadastro);
                            if ($clientsData['status']) {   
                                $id_form = $clientsData['client']['id'];
                                $name_form = $clientsData['client']['name'];
                                $cpf_form = $clientsData['client']['cpf'];
                                $creci_form = $clientsData['client']['creci'];
                                echo <<<HTML
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" minlength="2" value="{$name_form}" id="name_form" name="name_form" placeholder="name_form" required>
                                            <label for="name_form">Nome</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" minlength="11" value="{$cpf_form}" maxlength="11" id="cpf_form" name="cpf_form" placeholder="cpf_form" required>
                                            <label for="cpf_form">CPF</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" minlength="2" value="{$creci_form}" id="creci_form" name="creci_form" placeholder="creci_form" required>
                                            <label for="creci_form">Creci</label>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{$id_form}" name="id_form">
                                </div>
                                HTML;
                                
                            }else {
                                $message = $clientsData['message'];
                                echo <<<HTML
                                <script>
                                    Swal.fire({
                                        title: "{$message}",
                                        icon: "error"
                                    }).then(() => {
                                        window.location.href = "index.php";
                                    });
                                </script>
                                HTML;
                            }
                         ?>
     

                        <!-- Botão centralizado -->
                        <div class="d-grid">
                            <button type="submit" name="envia_form" class="btn btn-primary">Alterar</button>
                        </div>
                    </form>


                    <?php
                        if(isset($_REQUEST['envia_form'])){
                            $name_form = $_REQUEST['name_form'];
                            $cpf_form = $_REQUEST['cpf_form'];
                            $creci_form = $_REQUEST['creci_form'];
                            $id_form = $_REQUEST['id_form'];

                            
                            if ((strlen($cpf_form) === 11) && (strlen($name_form) > 2 ) && (strlen($creci_form> 2)) ){
                                $updateClient = $objectClients->updateUser($id_form, $name_form, $cpf_form, $creci_form);
                                $message = $updateClient['message'];
                                if ($updateClient['status']) {
                                    echo <<<HTML
                                    <script>
                                        Swal.fire({
                                            title: "{$message}",
                                            icon: "success"
                                        }).then(() => {
                                            window.location.href = "index.php";
                                        });
                                    </script>
                                    HTML;
                                }else {
                                    echo <<<HTML
                                    <script>
                                        Swal.fire({
                                            title: "{$message}",
                                            icon: "error"
                                        }).then(() => {
                                            window.location.href = "index.php";
                                        });
                                    </script>
                                    HTML;
                                }
                            } else {
                                echo <<<HTML
                                <script>
                                    Swal.fire({
                                        title: "Valores invalidos",
                                        icon: "error"
                                    }).then(() => {
                                        window.location.href = "index.php";
                                    });
                                </script>
                                HTML;
                            }
                        }
                    ?>


                </div>
            </div>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-secondary" onclick="voltar()" type="button">Voltar</button>
        </div>
    </div>
    <script>
        function voltar() {
            window.history.back();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
