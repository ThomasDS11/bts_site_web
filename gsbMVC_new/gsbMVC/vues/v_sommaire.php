<ul id="menuList1">
    <li class="smenu">
        <a href="index.php?uc=connexion&action=valideConnexion"><span class="glyphicon glyphicon-home"></span>  Accueil</a>
    </li>
    <li class="smenu">
        <a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais ">Saisie fiche de frais</a>
    </li>

    <li class="smenu">
        <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
    </li>

    <li class="smenu">
        <a href="index.php?uc=deconnexion&action=demandeDeconnexion" title="Se déconnecter">Déconnexion</a>
    </li>
</ul>
</div>
<br>
<div class="content1">
    <img src="images/logo.jpg" alt="logo">
</div>
<div class="user">
    <h2>
        Gestion des frais<small> - Visiteur :
            <?php
            echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']
            ?></small>
    </h2>
</div><br>