<?php
require_once("include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();

/*
try{
    $pdo = new PDO("mysql:host=" . bdd_server . ";dbname=" . bdd_name, bdd_user, bdd_password);

   // $dsn = 'mysql:dbname=QCM_DATA;host=127.0.0.1';
   // $user = "phpuser";
   // $password = "php";

 //   $pdo = new PDO($dsn, $user, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>
 * */
 
 

$id_ajout= filter_input(INPUT_POST, 'id');
$lebelle_ajout= filter_input(INPUT_POST, 'libelle');
$montant_ajout= filter_input(INPUT_POST, 'montant');

$statement_request = $pdo->prepare("INSERT INTO fraisforfait (id, libelle, montant)
VALUES (:id, :libelle, :montant"); 
$statement_request->bindParam(":id", $id_ajout);
$statement_request->bindParam(":libelle", $lebelle_ajout);
$statement_request->bindParam(":montant", $montant_ajout);
$statement_request->execute();     

