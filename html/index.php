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
<?php
//dados de login do rds

$usuario = "mysql_site"; //digite seu nome de usuario no mysql aqui
$senha = "12345678"; //digite sua senha de acesso ao mysql aqui

//Conecta com o RDS
$dbh = new PDO('mysql:host=mysql-site.cn7eudsxqztw.eu-west-1.rds.amazonaws.com;dbname=tabela_brasileirao', $usuario, $senha);
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="page-header">
                <h1 align = "center"> Times brasileirão 2015 </h1>
            </div>
            <!-- tenta conexão com o bd -->
            <!--   Combo box para selecionar as series  -->
            <article>
                <div class='panel'>
                    <div class='panel-body' align = 'center'>
                        <div class='input-group' >
                            <form method="POST">
                                <span><h3> Série : </h3></span>
                                <select name="serie_selecionado" method='POST'>
                                    <?php
                                    $buscaSerie = $dbh->prepare("SELECT DISTINCT serie FROM Tabela");
                                    $buscaSerie->execute();
                                    $linhasSerie = $buscaSerie->fetchall(PDO::FETCH_ASSOC);

                                    foreach($linhasSerie as $linha) {
                                        echo "<option>" . $linha["serie"] . "</option>";
                                    }
                                    ?>
                                </select>
                        </div>
                        <div align="center" 2class="col-md-3">
                            <input type="submit" class="btn btn-primary" value="Ver tabela" />
                        </div>
                        </form>
                    </div>
                </div>
            </article>

            <?php if (isset($_POST["serie_selecionado"]) ? $_POST["serie_selecionado"] : false); ?>

            <h3 align = 'center'>Brasileirao <?php echo $_POST["serie_selecionado"]; ?></h3>
            <table class= "table table-striped col-md-10" align = "center">
                <thead>
                <tr>
                <tr>
                    <th>Time</th>
                    <th>Pontuação</th>
                <tr>
                </thead>
                <tbody>
                <?php
                //Consulta os times e as pontuações no BD
                $buscaTimes = $dbh->prepare("SELECT * FROM Tabela WHERE serie='" . $_POST["serie_selecionado"] . "' ORDER BY pontuacao DESC");
                $buscaTimes->execute();
                $linhasTimes = $buscaTimes->fetchall(PDO::FETCH_ASSOC);
                echo "<!-- Conectar com o banco de dados para pegar os times da serie selecionada -->";
                foreach($linhasTimes as $linhaTime){
                    echo "<tr><td>". $linhaTime["time"] . "</td><td>". $linhaTime["pontuacao"] . "</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>

<br><br><br>
<div id="espaco"></div>
<div id="footer">
    <div class="container">
        <p class="muted credit" align="center">Lucas Nascimento Cabral e Páblo Victor Félix dos Santos - Capacitaçã Huawei - Módulo 3 </p>
    </div>
</div>
</html>