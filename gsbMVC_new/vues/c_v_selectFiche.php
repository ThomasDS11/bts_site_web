<!-- Division pour le sommaire -->
<div class="container">
<div class="row">
    <div id="" class="col-md-8 col-lg-8 col-sm-8" style="border-radius: 30px">

        <form method="GET" action="index.php">
        <input type="hidden" name="uc" value="validFrais">
        <input type="hidden" name="action" value="recherche">

        <h3>Sélectionner un visiteur :</h3>

            <input name="visiteur" type="text" >

        <h3>Selectionner une date :</h3>

            <select name="mois">
            <?php
                for($i = 1; $i <= 12; $i++){
                    echo '<option>';
                    if($i < 10){
                        echo "0";
                    }
                    echo $i;
                    echo '</option>';
                }
            ?>
            </select>

            <select name="annee">
                <?php
                    for($i = date("y"); $i >= 10; $i--){
                        echo '<option>20'.$i.'</option>';
                    }
                ?>
            </select>
            <br><br>
            <button class="btn btn-primary" type="submit">Rechercher</button>

        </form>
    </div>
</div>