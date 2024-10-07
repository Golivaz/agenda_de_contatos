<!-- 
 Guilherme de Oliveira Rodrigues
 goliva12@hotmail.com
 -->
<?php

$host = "localhost";
$dbname = "agenda";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    //erro na conexao
    $error = $e->getMessage();
    echo "Erro: $error";
}

?>