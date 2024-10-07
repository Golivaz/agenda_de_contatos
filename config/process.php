<?php

session_start();

include_once("conection.php");
include_once("url.php");

if (!empty($_GET)) {
    $id = $_GET["id"];
}

//Retorna o dado de um contato
if (!empty($id)) {

    $query = "SELECT * FROM contacts WHERE id = :id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $contact = $stmt->fetch();

} else {

    //Retornas todos os contatos
    $contacts = [];

    $query = "SELECT * FROM contacts";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $contacts = $stmt->fetchAll();

}

?>