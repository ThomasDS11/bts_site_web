<hr>
<div class="container">
<div class="row">
<div class="panel panel-primary">
        <div class="panel-heading">Fiche de frais du mois 
            <?php echo $leMois."-".$Annee?> :
        </div>
            <div class="panel-body">
                <?php
                foreach ( $lesFrais as $unFraisForfait )
                {
                $nom = $unFraisForfait['nom'];
                $prenom = $unFraisForfait['prenom'];
                $montant = $unFraisForfait['montantValide'];
                $date = $unFraisForfait['dateModif'];
                $libelle = $unFraisForfait['libelle'];
                $idVisiteur = $unFraisForfait['id'];
                ?>
                    <div class="container">
                        <div class="row1">

                            <table class="listeLegere table table-bordered table-responsive">
                                <tr>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Etat</th>
                                </tr>
                                <tr>
                                    <td><?php echo $nom ?></td>
                                    <td><?php echo $prenom ?></td>
                                    <td><?php echo $montant ?></td>
                                    <td><?php echo $date ?></td>
                                    <td><?php echo $libelle ?></td>
                                    
                                    <a href="index.php?uc=validFrais&action=voir&idvisiteur=<?=$idVisiteur ?>&mois=<?=$Annee.$leMois?>" title="valider fiche de frais ">Voir</a>
                                </tr>
                            </table>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
