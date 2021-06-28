<?php

include("vues/c_v_sommaire.php");
$action = filter_input(INPUT_GET, 'action');
$leMois = filter_input(INPUT_GET, 'mois');
$Annee= filter_input(INPUT_GET, 'annee');
$prenom= filter_input(INPUT_GET, 'visiteur');

$idComptable = $_SESSION['idVisiteur'];

switch ($action) {
    case'recherche':{

        include ("vues/c_v_selectFiche.php");
        $lesFrais = $pdo->getTousLesFrais($Annee,$leMois,$prenom);
        $numAnnee =substr( $leMois,0,4);
        $numMois =substr( $leMois,4,2);
        include("vues/c_v_Etatfrais.php");
        break;
    }
    case'voir':{
        $idVisiteur= filter_input(INPUT_GET, 'idvisiteur');
        $mois= filter_input(INPUT_GET, 'mois');
        if(isset($_POST['value'])){
            $pdo->majEtatFicheFraisHorsForfait($idVisiteur,$mois,$_POST['value']);
        }
        $lesInfos = $pdo->getLaFiche($idVisiteur,$mois);
        $lesInfosFiche = $pdo->getInfosFicheFraisForfait($idVisiteur,$mois);
        $lesInfosFicheHorsForfait=$pdo->getInfosFicheFraisHorsForfait($idVisiteur,$mois);
        include("vues/c_v_Voirfiche.php");
        break;
    }
}
?>