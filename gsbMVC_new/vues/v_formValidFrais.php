<html>
<head>
	<title>Validation des frais de visite</title>
	<style type="text/css">
		<!-- body {background-color: white; color:EE8855; }
			.titre { width : 180 ;  clear:left; float:left; }
			.zone { float : left; color:CC8855 } -->
	</style>
</head>
<div>
    <div name="gauche" style="clear:left:;float:left;width:18%; background-color:white; height:100%;">
        <div name="coin" style="height:10%;text-align:center;"><img src="images/logo.jpg" width="100" height="60"/></div>
        <div name="menu" >
            <h2>Outils</h2>
            <ul><li>Frais</li>
                <ul>
                    <li><a href="formValidFrais.htm" >Enregistrer op�ration</a></li>
                </ul>
            </ul>
        </div>
    </div>
</div>
<div name="droite" style="float:left;width:80%;">
	<div name="haut" style="margin: 2 2 2 2 ;height:10%;float:left;"><h1>Validation des Frais</h1></div>
	<div name="bas" style="margin : 10 2 2 2;clear:left;background-color:EE8844;color:white;height:88%;">
	<form name="formValidFrais" method="post" action="enregValidFrais.php">
		<h1> Validation des frais par visiteur </h1>
		<label class="titre">Choisir la fiche de frais à traiter :</label>
        <p style="center">
            <?php foreach ($lesInfosTabFicheFrais as $ficheFrais ){
                $VisiteurNom =$ficheFrais['visiteurNom'];
                $VisiteurPrenom =$ficheFrais['visiteurPrenom'];
                $montantValide = $ficheFrais['montantValide'];
                $nbJustificatifs = $ficheFrais['nbJustificatifs'];
                $dateModif =  $ficheFrais['dateModif'];
                $dateModif =  dateAnglaisVersFrancais($dateModif);
            echo $VisiteurPrenom  . $VisiteurNom . ":" . $nbJustificatifs ."justificatifs depuis le" . $dateModif."Montant validé :". $montantValide."<br>";
            }
                ?>
        </p>
	</form>
	</div>
</div>
</body>
</html>