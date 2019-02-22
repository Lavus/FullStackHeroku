<?php # indentificação que o codigo a partir deste ponto serás PHP
    $host='localhost'; # local onde está o banco de dados
    $user='root'; # login do banco de dados
    $pass=''; # senha do banco de dados
    $base='fullstack'; # nome do banco de dados
    $mysqli = new mysqli($host,$user,$pass,$base); # criando conexão com o banco de dados mysql segundo as especificações passadas
    if ($mysqli->connect_errno) { # verifica se ocorreu erro ao criar a conexão
        printf("Connect failed: %s\n", $mysqli->connect_error); # mostra que a conexão falhou e qual foi o erro
        exit(); # fecha tudo
    } # fim da verificação
?> <!-- indentificação que acabou o codigo em PHP -->
