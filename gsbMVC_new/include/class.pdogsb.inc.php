<?php
/**
 * Classe d'accès aux données.

 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO
 * $monPdoGsb qui contiendra l'unique instance de la classe

 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsbv2';
      	private static $user='phpuser';
      	private static $mdp='php';
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
        PdoGsb::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe

 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();

 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;
	}
/**
 * Retourne les informations d'un Visiteur

 * @param $login
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif
*/
	public function getInfosVisiteur($login){
		$req = "select visiteur.id as id, visiteur.nom as nom, visiteur.mdp as mdp, visiteur.prenom as prenom from visiteur
		where visiteur.login='$login'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}
        public function getInfosComptable($login){
		$req = "select comptable.id as id, comptable.nom as nom, comptable.mdp as mdp,comptable.prenom as prenom from comptable
		where comptable.login='$login'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}

	/**
 * Fonction qui retourne les mots de passe

		*/
		public function lesMdp(){
			$logs="SELECT mdp , login from comptable";
			$rs = PdoGsb::$monPdo->query($logs);
			$tab = $rs->fetchALL();
			return $tab;
		}
/**
 * fonction qui hash les mots de passe en bdd

 */
		public function hashLesMdp($tab){
			foreach ($tab as $key){
				$hash = password_hash($key['mdp'], PASSWORD_DEFAULT);
				echo $hash."<br>";
				$log=$key['login'];
				$rq = "UPDATE comptable set mdp = '$hash' where login = '$log'";
				$rs = PdoGsb::$monPdo->query($rq);



			}
		}


/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
 * concernées par les deux arguments

 * La boucle foreach ne peut être utilisée ici car on procède
 * à une modification de la structure itérée - transformation du champ date-

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idVisiteur ='$idVisiteur'
		and lignefraishorsforfait.mois = '$mois' ";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['date'];
			$lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
		}
		return $lesLignes;
	}
/**
 * Fonction qui retourne les fiches en fonction des champs renseignés

 */
	public function getTousLesFrais($annee,$mois,$prenom){
		if(empty($annee)){
			$annee = date('y');
		}
		if(empty($mois)){
			$mois = date('m');
		}
		if(empty($prenom)){
			$req = 'select fichefrais.montantValide, etat.libelle, fichefrais.dateModif, visiteur.nom, visiteur.prenom, visiteur.id
 			from fichefrais inner join visiteur on fichefrais.idVisiteur = visiteur.id inner join etat on fichefrais.idEtat = etat.id and fichefrais.mois ='.$annee.$mois;
		}
		else{
			$req = "select fichefrais.montantValide, etat.libelle, fichefrais.dateModif, visiteur.nom, visiteur.prenom, visiteur.id
			from fichefrais inner join visiteur on fichefrais.idVisiteur = visiteur.id inner join etat on fichefrais.idEtat = etat.id and fichefrais.mois =".$annee.$mois." 
			and visiteur.nom like '%".$prenom."%'";
		}
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['dateModif'];
			$lesLignes[$i]['dateModif'] =  dateAnglaisVersFrancais($date);
		}
		return $lesLignes;
	}
/**
 * Fonction qui retourne les fiches en fonction du mois selectionné

 */
	public function getLaFiche($idVisiteur,$mois){
		$req = "select fichefrais.montantValide, etat.libelle, fichefrais.dateModif, visiteur.nom, visiteur.prenom, visiteur.id
 			from fichefrais inner join visiteur on fichefrais.idVisiteur = visiteur.id inner join etat on fichefrais.idEtat = etat.id and mois ='$mois' and visiteur.id ='$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetch(PDO::FETCH_ASSOC);

		return $lesLignes;
	}
/**
 * Fonction qui retourne les fiches en fonction des champs renseignés

 */
	public function getInfosFicheFraisForfait($idVisiteur,$mois){
		$req = "select lignefraisforfait.quantite, fraisforfait.libelle, fraisforfait.montant from lignefraisforfait inner join fraisforfait on fraisforfait.id = lignefraisforfait.idFraisForfait
		and lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll(PDO::FETCH_ASSOC);

		return $lesLignes;
	}
/**
 * Fonction qui retourne les fiches hors forfaits en fonction des champs renseignés

 */
	public function getInfosFicheFraisHorsForfait($idVisiteur,$mois){
		$req = "select lignefraishorsforfait.libelle,  lignefraishorsforfait.date, lignefraishorsforfait.montant, etat.id, etat.libelle as etat from lignefraishorsforfait 
        inner join etat on lignefraishorsforfait.idEtat = etat.id
        where lignefraishorsforfait.idvisiteur ='$idVisiteur' and lignefraishorsforfait.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll(PDO::FETCH_ASSOC);

		return $lesLignes;
	}

/**
 * Retourne le nombre de justificatif d'un Visiteur pour un mois donné

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @return le nombre entier de justificatifs
*/
	public function getnbJustificatifs($idVisiteur, $mois){
		$req = "select fichefrais.nbJustificatifs as nb from  fichefrais where fichefrais.idVisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['nb'];
	}
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif
*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle,
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait
		on fraisforfait.id = lignefraisforfait.idFraisForfait
		where lignefraisforfait.idVisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois'
		order by lignefraisforfait.idFraisForfait";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
/**
 * Retourne tous les id de la table FraisForfait

 * @return un tableau associatif
*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
/**
 * Met à jour la table LigneFraisForfait

 * Met à jour la table LigneFraisForfait pour un Visiteur et
 * un mois donné en enregistrant les nouveaux montants

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return un tableau associatif
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idVisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idFraisForfait = '$unIdFrais'";
			PdoGsb::$monPdo->exec($req);
		}

	}
/**
 * Fonction qui modifie l'etat d'une fiche frais hors forfait
 */
	public function majEtatFicheFraisHorsForfait($idVisiteur,$mois,$Etat,$libelle){
        $req = "update lignefraishorsforfait set idEtat = '$Etat', dateModif = now()
        where lignefraishorsforfait.idVisiteur ='$idVisiteur' and lignefraishorsforfait.mois = '$mois' and lignefraishorsforfait.libelle = '$libelle' ";
        PdoGsb::$monPdo->exec($req);
    }
/**
 * Fonction qui modifie l'etat d'une fiche frais forfait
 */  
  	public function majEtatFicheFraisForfait($idVisiteur,$mois,$Etat){
		$req = "update fichefrais set idEtat = '$Etat', dateModif = now()
        where fichefrais.idVisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * met à jour le nombre de justificatifs de la table FicheFrais
 * pour le mois et le Visiteur concerné

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
*/
	public function majnbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = " update fichefrais set nbJustificatifs = $nbJustificatifs
		where fichefrais.idVisiteur = '$idVisiteur' and fichefrais.mois = '$mois' ";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * Test si un visiteur possède une fiche de frais pour le mois passé en argument

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux
*/
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais
		where fichefrais.mois = '$mois' and fichefrais.idVisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un Visiteur

 * @param $idVisiteur
 * @return le mois sous la forme aaaamm
*/
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idVisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}

/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un Visiteur et un mois donnés

 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles
 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
		}
		$req = "insert into fichefrais(idVisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat)
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		PdoGsb::$monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idVisiteur,mois,idFraisForfait,quantite)
			values('$idVisiteur','$mois','$unIdFrais',0)";
			PdoGsb::$monPdo->exec($req);
		 }
	}
/**
 * Crée un nouveau frais hors forfait pour un Visiteur un mois donné
 * à partir des informations fournies en paramètre

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$idEtat="CR";
        $dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait (idVisiteur, mois, libelle, date, montant,idEtat)
		values('$idVisiteur','$mois','$libelle','$dateFr','$montant','$idEtat')";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * Supprime le frais hors forfait dont l'id est passé en argument

 * @param $idFrais
*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id ='$idFrais' ";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * Retourne les mois pour lesquel un Visiteur a une fiche de frais

 * @param $idVisiteur
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant
*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idVisiteur ='$idVisiteur'
		order by fichefrais.mois desc ";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch();
		}
		return $lesMois;
	}
/**
 *

 *
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant
 */
public function getTousLesMoisDisponibles(){
	$req = "select fichefrais.mois as mois from  fichefrais
	order by fichefrais.mois desc ";
	$res = PdoGsb::$monPdo->query($req);
	$lesMois =array();
	$laLigne = $res->fetch();
	while($laLigne != null)	{
		$mois = $laLigne['mois'];
		$numAnnee =substr( $mois,0,4);
		$numMois =substr( $mois,4,2);
		$lesMois["$mois"]=array(
			"mois"=>"$mois",
			"numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
		);
		$laLigne = $res->fetch();
	}
	return $lesMois;
}
/**
 * Retourne les informations d'une fiche de frais d'un Visiteur pour un mois donné

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état
*/
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs,
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id
			where fichefrais.idVisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}
/**
 * Modifie l'état et la date de modification d'une fiche de frais

 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 */

	public function majEtatFicheFrais($idVisiteur,$mois,$Etat){
		$req = "update fichefrais set idEtat = '$Etat', dateModif = now()
		where fichefrais.idVisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}

/**
 * Affiche au comptable les fiche à traiter

 *
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état
 */
public function getFicheFraisCL($mois){
	$req = "select fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs,
		fichefrais.montantValide as montantValide, visiteur.nom as visiteurNom, visiteur.prenom as visiteurPrenom 
		from  fichefrais inner join visiteur on visiteur.id = fichefrais.idVisiteur 
		where fichefrais.idEtat ='CL' and fichefrais.mois = '$mois' limit 20";
	$res = PdoGsb::$monPdo->query($req);
	$laLigne = $res->fetchAll();
	return $laLigne;
}


}
?>