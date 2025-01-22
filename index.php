<?php
    require_once "functions.php";
    require_once __DIR__ . "/vendor/autoload.php";

    use application\controllers\ControllerClientAPI;
    $objectClients = new ControllerClientAPI();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastros de Corretores</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="container text-center py-4">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col">
                    <h1>Cadastro de Corretor</h1>
                </div>
            </div>
            
           <!-- Form Section -->
            <div class="row mb-4">
                <div class="col">
                    <form action="" method="POST">
                        <!-- Inputs alinhados lado a lado -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" minlength="2" id="name_form" name="name_form" placeholder="name_form" required>
                                    <label for="name_form">Nome</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" minlength="11" maxlength="11" id="cpf_form" name="cpf_form" placeholder="cpf_form" required>
                                    <label for="cpf_form">CPF</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" minlength="2" id="creci_form" name="creci_form" placeholder="creci_form" required>
                                    <label for="creci_form">Creci</label>
                                </div>
                            </div>
                        </div>

                        <!-- Botão centralizado -->
                        <div class="d-grid">
                            <button type="submit" name="envia_form" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
                if(isset($_REQUEST['envia_form'])){
                    $name_form = $_REQUEST['name_form'];
                    $cpf_form = $_REQUEST['cpf_form'];
                    $creci_form = $_REQUEST['creci_form'];


                    if ((strlen($cpf_form) === 11) && (strlen($name_form) > 2 ) && (strlen($creci_form> 2)) ){
                        $postClient = $objectClients->createlUser($name_form, $cpf_form, $creci_form);
                        $message = $postClient['message'];
                        if ($postClient['status']) {
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
            <!-- Table Section -->
            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead class="table">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">CPF</th>
                                <th scope="col">CRECI</th>
                                <th scope="col">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $clientsData = $objectClients->returnAllUsers();

                            if ($clientsData['status']) {
                                foreach ($clientsData['client'] as $client) {
                                    $id = $client['id'];
                                    $cpf_formatado = formatarCPF($client['cpf']);
                                    echo <<<HTML
                                            <tr>
                                                <th scope="row">{$id}</th>
                                                <td>{$client['name']}</td>
                                                <td>{$cpf_formatado}</td>
                                                <td>{$client['creci']}</td>
                                                <td><a href="editar.php?id=$id">Editar</a> / <a href="index.php?excluir=excluir&&id=$id">Excluir</a></td>
                                            </tr>
                                    HTML;
                                }
                            }else {
                                echo "Não há clientes para exibir.\n";
                            }
                        ?>

                        </tbody>
                    </table>
                    <?php   
                        if(isset($_REQUEST['excluir'])){
                            $idExcluir = $_REQUEST['id'];
                            $delClient = $objectClients->deletelUser($idExcluir);
                            $message = $delClient['message'];
                            
                            if ($delClient['status']) {
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
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
