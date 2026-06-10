<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conexao.php");

$name = $_POST['name'];
$companyName = $_POST['companyName'];
$email  = $_POST['email'];
$phone = $_POST['phone'];
$locate = $_POST['locate'];
$typeDocument = $_POST['typeDocument'];
$document = $_POST['document'];
$status = $_POST['status'];
$osDescripition = $_POST['osDescripition'];

$conn->begin_transaction();

try{
    $stmt = $conn-> prepare("INSERT INTO clientes (nome_responsavel, nome_empresa, email, telefone, endereco, tipo_documento, numero_documento) VALUES (?,?,?,?,?,?,?)");
    $stmt -> bind_param("sssssss", $name,$companyName,$email,$phone,$locate,$typeDocument,$document);

    $stmt->execute();

    $id_cliente = $conn->insert_id;

    $stmt_os = $conn->prepare("INSERT INTO ordens_servico (id_cliente, `status`, descricao) VALUES (?,?,?)");
    $stmt_os -> bind_param("iss", $id_cliente, $status, $osDescripition);

    $stmt_os->execute();   

    $conn->commit();

    echo "ok";

}catch (Exception $e ){
    $conn->rollback();
    echo "Erro: " . $e->getMessage();
}


$stmt->close();
$stmt_os->close();
$conn->close();
?>  

