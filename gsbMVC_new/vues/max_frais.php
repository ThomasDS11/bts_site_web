<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$statement_request = $pdo->prepare("SELECT MAX(MontantValide) From fichefrais" );
$statement_request->execute(); 
$max= $statement_request->fetch(PDO::FETCH_ASSOC);

/* $max1 = $statement_request["Montantvalide"];
 
 */


$statement_request1 = $pdo->prepare("SELECT idVisiteur From fichefrais where MontantValide =:max" );
$statement_request1->bindParam(":max", $max);
$statement_request1->execute(); 
$id= $statement_request1->fetch(PDO::FETCH_ASSOC);



$statement_request2 = $pdo->prepare("SELECT nom From visiteur where id =:id" );
$statement_request2->bindParam(":id", $id);
$statement_request2->execute(); 
$nom= $statement_request2->fetch(PDO::FETCH_ASSOC);


echo "$nom";
