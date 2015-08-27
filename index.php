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
$user = "equipe4Admin"; //nome de usuario
$pwd = "senha123*"; //senha de acesso
//Conecta com o bd
$dbh = new PDO("sqlsrv:server = tcp:equipe4servidor.database.windows.net,1433; Database = equipe4database", $user, $pwd);
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
		                            $buscaSerie = $dbh->prepare("SELECT DISTINCT serie_time FROM equipe4database.db_accessadmin.tabela_brasileirao");
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
        <p class="muted credit" align="center">Lucas Nascimento Cabral e Páblo Victor Félix dos Santos - Capacitaçã Huawei - Módulo Azure </p>
    </div>
</div>
</html>
