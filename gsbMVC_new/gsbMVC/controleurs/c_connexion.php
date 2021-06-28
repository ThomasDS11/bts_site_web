<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = filter_input(INPUT_POST, 'login');
		$mdp = filter_input(INPUT_POST, 'mdp');
        $visiteur = $pdo->getInfosVisiteur($login);
        $comptable= $pdo->getInfosComptable($login);
	
        if($visiteur!=false){
			if(password_verify($mdp, $visiteur['mdp'])){
				$id = $visiteur['id'];
				$nom =  $visiteur['nom'];
				$prenom = $visiteur['prenom'];
				connecter($id,$nom,$prenom);
				include("vues/v_sommaire.php");
				include("vues/v_accueil.php");
			}
        }

        else if($comptable!=false){
			if(password_verify($mdp, $comptable['mdp'])){
				$id = $comptable['id'];
				$nom =  $comptable['nom'];
				$prenom = $comptable['prenom'];
				connecter($id,$nom,$prenom);
				include("vues/c_v_sommaire.php");
				include("vues/c_v_selectFiche.php");
			}
        }
		else{
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}

		break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>