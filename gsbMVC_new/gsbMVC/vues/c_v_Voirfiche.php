<div class="container">
<div class="row">
<h3>Fiche Frais de <?php echo $lesInfos['prenom']."  ".$lesInfos['nom'];?> :</h3>
<br>
<div class="panel panel-primary">
        <div class="panel-heading">Fiche Frais Forfait :
        </div>
    <div class="encadre">
    <table class="listeLegere table table-bordered table-responsive">
        <thead>
        <tr>
            <th colspan="1">libelle</th>
            <th colspan="1">quantite</th>
            <th colspan="1">montant</th>
            <th colspan="1">total</th>
        </tr>
        </thead>
        <?php
        foreach ($lesInfosFiche as $key) {
        $quantite = $key['quantite'];
        $montant = $key['montant'];
        $libelle = $key['libelle'];
        $total = $quantite*$montant;

        ?>
            <tbody>
                <tr>
                    <td><?=$libelle?></td>
                    <td><?=$quantite?></td>
                    <td><?=$montant?></td>
                    <td><?=$total?></td>
                </tr>
            </tbody>
        <?php
        }
        ?>
    </table>
    </div>
    <div class="panel-heading">Fiche Frais Hors Forfait :
    </div>

    <div class="encadre">
        <table class="listeLegere table table-bordered table-responsive">
            <thead>
            <tr>
                <th colspan="1">libelle</th>
                <th colspan="1">date</th>
                <th colspan="1">montant</th>
                <th colspan="1">Etat</th>
            </tr>
            </thead>
            <tbody>
        <?php foreach ($lesInfosFicheHorsForfait as $key) {
            
            $date = $key['date'];
            $montant = $key['montant'];
            $libelle = $key['libelle'];
            $Etat = $key['etat'];
            $idEtat = $key['id'];
            ?>
                <tr>
                    <td colspan="1"><?=$libelle?></td>
                    <td colspan="1"><?=$date?></td>
                    <td colspan="1"><?=$montant?></td>
                    <td>
                        <form method="post" action="index.php?uc=validFrais&action=voir&idvisiteur=<?=$idVisiteur ?>&mois=<?=$Annee.$leMois?>">
                            <select name="value">
                                
                                <option value="<?=$idEtat?>"><?=$Etat?></option>
                                <option value="CL">CL - Saisie clôturée</option>
                                <option value="CR">CR - Fiche créée, saisie en cours</option>
                                <option value="RB">RB - Remboursée</option>
                                <option value="VA">VA - Validée et mise en paiement</option>
                                <option value="RE">RE - Refusé</option>
                                <input type="submit" value="modifier">
                            </select>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
            <?php
        }
        ?>
    </div>
  </div>