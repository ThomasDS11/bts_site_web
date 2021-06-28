<div class="container">
<div class="row">
<div id="contenu">
      <h2>Mes fiches de frais</h2>
      <h3>Mois à sélectionner : </h3>
      <form action="index.php?uc=etatFrais&action=voirEtatFrais" method="post">
      <div class="corpsForm">
        <label for="lstMois" accesskey="n">Mois : </label>
        <select id="lstMois" name="lstMois" class="form-control">
          <?php
          foreach ($lesMois as $unMois) {
              $mois = $unMois['mois'];
              $numAnnee =  $unMois['numAnnee'];
              $numMois =  $unMois['numMois'];
              if ($mois == $moisASelectionner) {
                ?>
				<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
			
			}
           
		   ?>    
            
        </select>
      </div>
      <br>
      <div class="piedForm">
        <input id="ok" class="btn btn-primary" type="submit" value="Valider" size="20" />
        <input id="annuler" class="btn btn-danger" type="reset" value="Effacer" size="20" />
      </div>
        
      </form>