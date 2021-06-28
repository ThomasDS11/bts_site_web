<ul id="menuList">

<li class="smenu">
        <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
    </li>
    <li class="smenu">
        <a href="index.php?uc=validFrais&action=recherche" title="Saisie fiche de frais ">Saisie fiche de frais</a>
    </li>
</ul>
<div class="content1">
    <img src="images/logo.jpg" alt="logo">
</div>
<div class="user">
    <h2>
        Gestion des frais<small> - Comptable :
            <?php
            echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']
            ?></small>
    </h2>
</div><br>