<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<head>
    <title> Aplicaçao Huawei </title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>


</head>

<body>
<!--  Cabeçalho  -->
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="page-header">
                <h1 align = "center"> Times brasileirão 2015 </h1>
            </div>

            <!-- tenta conexão com o bd -->
            <?php
            $host = "mysql-site.cn7eudsxqztw.eu-west-1.rds.amazonaws.com port=3306"
		$usuario = "MySQL_site"; //digite seu nome de usuario no mysql aqui
		$senha = "12345678"; //digite sua senha de acesso ao mysql aqui
		$conexao = mysql_connect($host,$usuario,$senha) or die ("N&atilde;o foi poss&iacute;vel conectar ao banco de dados");
		mysql_select_db("tabela_brasileirao") or die("Base de dados n&atilde;o encontrada"); ?>


            <!--
        <?php $conexao = mysql_connect("host= mysql-example.cn7eudsxqztw.eu-west-1.rds.amazonaws.com port=3306 dbname=mysql_site user=mysql_site password=12345678")
            or die ("<br><div class=\"alert alert-warning\" role=\"alert\">Não foi possivel conectar ao servidor MySQL</div>");
            ?>
        <div id="success-alert" class="alert alert-success" role="alert"> Conexão efetuada com sucesso!! </div>
        -->



            <!--   Combo box para selecionar a liga, carregando do banco de dados os nomes das ligas  -->
            <article>
                <div class="panel">
                    <div class="panel-body" align = "center">
                        <div class="input-group" >
                            <span class="btn btn-small btn-primary"> Série : </span>

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

                        </div>
                        <div align="center" 2class="col-md-3">
                            <input type="submit" class="btn btn-primary" value="Ver tabela" />
                        </div>
                    </div>
                </div>
            </article>



            <!-- verifica se alguma liga foi selecionada -->
            <?php if (isset($_POST['liga']) ? $_POST['liga'] : false): ?>

                <h3 align = "center">Brasileirao <?php echo $_POST['liga']; ?> </h3>

                <table class="table table-striped" align = "center">

                    <thead>
                    <tr>
                        <th>Time</th>
                        <th>Pontuaçao</th>
                    </tr>
                    </thead>


                    <tbody >

                    <!-- Conectar com o banco de dados para pegar os times da liga -->
                    <?php
                    $result = pg_query("SELECT time FROM tabela WHERE liga = '" . $_POST['liga']"' ORDER BY pontuacao DESC;'");
                        while ($row = pg_fetch_array($result)) {
                            echo "<tr><td>". $row.["time"] . "</td><td>". $row.["pontuacao"] . "</td></tr>";
                        }
                ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>
    </div>
</div>

</body>


<br><br><br><br><br><br><br><br><br>
<div id="espaco"></div>
<div id="footer">
    <div class="container">
        <p class="muted credit" align="center">Lucas Nascimento Cabral e Páblo Victor Félix - Capacitaçã Huawei - Módulo 3 </p>
    </div>
</div>
</html>
