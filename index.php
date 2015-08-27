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
<?php
    // Variables to tune the retry logic.  
    $connectionTimeoutSeconds = 30;  // Default of 15 seconds is too short over the Internet, sometimes.
    $maxCountTriesConnectAndQuery = 3;  // You can adjust the various retry count values.
    $secondsBetweenRetries = 4;  // Simple retry strategy.
    $errNo = 0;
    
    //TODO: Update the values on $serverName and $connectionOptions
    //using the values you retrieved earlier from the portal.
    $serverName = "equipe4servidor.database.windows.net,1433";
    $connectionOptions = array("Database"=>"equipe4database",
     "Uid"=>"equipe4Admin", "PWD"=>"senha123*", "LoginTimeout" => $connectionTimeoutSeconds);
    $conn;
    $errorArr = array();
    
    for ($cc = 1; $cc <= $maxCountTriesConnectAndQuery; $cc++)
    {
        $errorArr = array();
        $ctr = 0;
        // [A.2] Connect, which proceeds to issue a query command. 
        $conn = sqlsrv_connect($serverName, $connectionOptions);  
    if($conn == false){
            if( ($errors = sqlsrv_errors() ) != null) {
                foreach( $errors as $error ) {
                    $errorArr[$ctr] = $error['code'];
                    $ctr = $ctr + 1;
                }
            }
            $isTransientError = TRUE;
            // [A.4] Check whether sqlExc.Number is on the whitelist of transients.
            $isTransientError = IsTransientStatic($errorArr);
            if ($isTransientError == TRUE)  // Is a static persistent error...
            { 
                echo("Persistent error suffered, SqlException.Number==". $errorArr[0].". Program Will terminate."); 
                echo "<br>";
                // [A.5] Either the connection attempt or the query command attempt suffered a persistent SqlException.
                // Break the loop, let the hopeless program end.
                exit(0);
            }
            // [A.6] The SqlException identified a transient error from an attempt to issue a query command.
            // So let this method reloop and try again. However, we recommend that the new query
            // attempt should start at the beginning and establish a new connection.
            if ($cc >= $maxCountTriesConnectAndQuery)
            {
                echo "Transient errors suffered in too many retries - " . $cc ." Program will terminate.";
                echo "<br>";
                exit(0);
            }
            echo("Transient error encountered.  SqlException.Number==". $errorArr[0]. " . Program might retry by itself.");  
            echo "<br>";
            echo $cc . " Attempts so far. Might retry.";
            echo "<br>";
            // A very simple retry strategy, a brief pause before looping. This could be changed to exponential if you want.
            sleep(1*$secondsBetweenRetries);		
	} }
	
	    function IsTransientStatic($errorArr) {
        $arrayOfTransientErrorNumbers = array(4060, 10928, 10929, 40197, 40501, 40613);
        $result = array_intersect($arrayOfTransientErrorNumber, $errorArr);
        $count = count($result);
        if($count >= 0) //change to > 0 later.
            return TRUE;
    }

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
									<!-- FAZ PESQUISA AQUI -->
									
                                    <?php
                                    $tsql = "SELECT DISTINCT serie_time FROM tabela_brasileirao";
                                    $getSeries = sqlsrv_query($conn, $tsql);
                                    if ($getSeries == FALSE)
											die(FormatErrors(sqlsrv_errors()));
                                    
                                    $tsql-> execute();
                                    $linhasSerie = $tsql->fetchall(PDO::FETCH_ASSOC);

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
                <!-- FAZ PESQUISA AQUI -->
                //Consulta os times e as pontuações no BD
                $tsql = "SELECT * FROM Tabela WHERE serie='" . $_POST["serie_selecionado"] . "' ORDER BY pontuacao DESC";
                $getTimes = sqlsrv_query($conn, $tsql);
                if ($getTimes == FALSE)
						die(FormatErrors(sqlsrv_errors()));               
                
                $tsql->execute();
                $linhasTimes = $tsql->fetchall(PDO::FETCH_ASSOC);
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
Exibindo index.php.<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
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
<?php
    // Variables to tune the retry logic.  
    $connectionTimeoutSeconds = 30;  // Default of 15 seconds is too short over the Internet, sometimes.
    $maxCountTriesConnectAndQuery = 3;  // You can adjust the various retry count values.
    $secondsBetweenRetries = 4;  // Simple retry strategy.
    $errNo = 0;
    
    //TODO: Update the values on $serverName and $connectionOptions
    //using the values you retrieved earlier from the portal.
    $serverName = "equipe4servidor.database.windows.net,1433";
    $connectionOptions = array("Database"=>"equipe4database",
     "Uid"=>"equipe4Admin", "PWD"=>"senha123*", "LoginTimeout" => $connectionTimeoutSeconds);
    $conn;
    $errorArr = array();
    
    for ($cc = 1; $cc <= $maxCountTriesConnectAndQuery; $cc++)
    {
        $errorArr = array();
        $ctr = 0;
        // [A.2] Connect, which proceeds to issue a query command. 
        $conn = sqlsrv_connect($serverName, $connectionOptions);  
    if($conn == false){
            if( ($errors = sqlsrv_errors() ) != null) {
                foreach( $errors as $error ) {
                    $errorArr[$ctr] = $error['code'];
                    $ctr = $ctr + 1;
                }
            }
            $isTransientError = TRUE;
            // [A.4] Check whether sqlExc.Number is on the whitelist of transients.
            $isTransientError = IsTransientStatic($errorArr);
            if ($isTransientError == TRUE)  // Is a static persistent error...
            { 
                echo("Persistent error suffered, SqlException.Number==". $errorArr[0].". Program Will terminate."); 
                echo "<br>";
                // [A.5] Either the connection attempt or the query command attempt suffered a persistent SqlException.
                // Break the loop, let the hopeless program end.
                exit(0);
            }
            // [A.6] The SqlException identified a transient error from an attempt to issue a query command.
            // So let this method reloop and try again. However, we recommend that the new query
            // attempt should start at the beginning and establish a new connection.
            if ($cc >= $maxCountTriesConnectAndQuery)
            {
                echo "Transient errors suffered in too many retries - " . $cc ." Program will terminate.";
                echo "<br>";
                exit(0);
            }
            echo("Transient error encountered.  SqlException.Number==". $errorArr[0]. " . Program might retry by itself.");  
            echo "<br>";
            echo $cc . " Attempts so far. Might retry.";
            echo "<br>";
            // A very simple retry strategy, a brief pause before looping. This could be changed to exponential if you want.
            sleep(1*$secondsBetweenRetries);		
	} }
	
	    function IsTransientStatic($errorArr) {
        $arrayOfTransientErrorNumbers = array(4060, 10928, 10929, 40197, 40501, 40613);
        $result = array_intersect($arrayOfTransientErrorNumber, $errorArr);
        $count = count($result);
        if($count >= 0) //change to > 0 later.
            return TRUE;
    }

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
									<!-- FAZ PESQUISA AQUI -->
									
                                    <?php
                                    $tsql = "SELECT DISTINCT serie_time FROM tabela_brasileirao";
                                    $getSeries = sqlsrv_query($conn, $tsql);
                                    if ($getSeries == FALSE)
											die(FormatErrors(sqlsrv_errors()));
                                    
                                    $tsql-> execute();
                                    $linhasSerie = $tsql->fetchall(PDO::FETCH_ASSOC);

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
                <!-- FAZ PESQUISA AQUI -->
                //Consulta os times e as pontuações no BD
                $tsql = "SELECT * FROM Tabela WHERE serie='" . $_POST["serie_selecionado"] . "' ORDER BY pontuacao DESC";
                $getTimes = sqlsrv_query($conn, $tsql);
                if ($getTimes == FALSE)
						die(FormatErrors(sqlsrv_errors()));               
                
                $tsql->execute();
                $linhasTimes = $tsql->fetchall(PDO::FETCH_ASSOC);
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
