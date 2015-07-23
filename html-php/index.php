<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <head>
        <title> Aplicaçao Huawei </title>

        <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php $conexao = pg_connect("host= mysql-example.cn7eudsxqztw.eu-west-1.rds.amazonaws.com port=3306 dbname=mysqls-example user=site password=asdf1234")
        or die ("<br><div class=\"alert alert-warning\" role=\"alert\">Não foi possivel conectar ao servidor MySQL</div>");
        // tenta conectar ao banco de dados e mata a pagina se nao for possivel
        // se a pagina nao morrer, a mensagem a seguir eh exibida
        ?>
        <div id="success-alert" class="alert alert-success" role="alert">Conexão efetuada com sucesso!!</div>

        <!--   Combo box para selecionar a liga, carregando do banco de dados os nomes das ligas  -->
        <p align = "center"> Liga:
            <select name="liga">

                <?php
                $result = pg_query("SELECT DISTINCT liga FROM tabela ORDER BY liga;");
                if  ($result) {
                    while ($row = pg_fetch_array($result)) {
                        echo "<option>" . $row["liga"] . "</option>";
                    }
                }
                ?>
            </select> </p>

        <div class="col-md-3" align = "center">
            <input type="submit" value="Classificaçao" />
        </div>


        <!-- verifica se alguma liga foi selecionada -->
        <?php if (isset($_POST['liga']) ? $_POST['liga'] : false): ?>

            <div class="page-header">
                <h1>Brasileirao <?php echo $_POST['liga']; ?> </h1>
            </div>

            <table class="table table-striped" align = "center" border="1">
                <thead>
                <tr>
                    <th>Nome time</th>
                    <th>Pontuaçao</th>
                </tr>
                </thead>
                <tbody >
                <?php
                    $result = pg_query("SELECT time FROM tabela WHERE liga = '" . $_POST['liga']"'ORDER BY pontuacao DESC;'");
                        while ($row = pg_fetch_array($result)) {
                            echo "<tr><td>". $row.["time"] . "</td><td>". $row.["pontuacao"] . "</td></tr>";
                        }
                ?>
                <!-- Conectar com o banco de dados para pegar os times da liga -->
                </tbody>
            </table>
        <?php endif; ?>
    </body>
</html>