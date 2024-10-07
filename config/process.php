<!-- 
 Guilherme de Oliveira Rodrigues
 goliva12@hotmail.com
 -->

<?php

session_start();

include_once("conection.php");
include_once("url.php");



$data = $_POST;

//Modificaões no Banco de Dados
if (!empty($data)) {

    //print_r($data);


    //Criar Contato
    if ($data["type"] === "create") {
        $name = $data["name"];
        $phone = $data["phone"];
        $observations = $data["observations"];

        $query = "INSERT INTO contacts (name, phone, observations) VALUES (:name, :phone, :observations)";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":observations", $observations);

        try {

            $stmt->execute();
            $_SESSION["msg"] = "Contato criado com sucesso!";

        } catch (PDOException $e) {
            //erro na conexao
            $error = $e->getMessage();
            echo "Erro: $error";
        }

    } else if ($data["type"] === "edit") {

        $name = $data["name"];
        $phone = $data["phone"];
        $observations = $data["observations"];
        $id = $data["id"];

        $query = "  UPDATE contacts
                    SET name = :name,
                    phone = :phone,
                    observations = :observations
                    WHERE id = :id";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":observations", $observations);
        $stmt->bindParam(":id", $id);

        try {

            $stmt->execute();
            $_SESSION["msg"] = "Contato Atualizado com sucesso!";

        } catch (PDOException $e) {
            //erro na conexao
            $error = $e->getMessage();
            echo "Erro: $error";
        }

    } else if ($data["type"] === "delete") {

        $id = $data["id"];
        $query = "DELETE FROM contacts WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id);

        try {

            $stmt->execute();
            $_SESSION["msg"] = "Contato Removido com sucesso!";

        } catch (PDOException $e) {
            //erro na conexao
            $error = $e->getMessage();
            echo "Erro: $error";
        }
    }

    //Redirecionamento para a HOME
    header("Location:" . $BASE_URL . "../index.php");
    //Seleção de Dados
} else {
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

}

//Fecar Conexão
$conn = null;

?>