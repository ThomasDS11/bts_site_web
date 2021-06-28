<div class="content">
    <img src="images/logo.jpg" alt="logo">
</div>

<div class="container"><br>
    <div class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default" >

            <div class="panel-heading">
                <div class="panel-title text-center">Suivi des fiches de frais</div>
            </div>

            <div class="panel-body" >
                <form method="POST" action="index.php?uc=connexion&action=valideConnexion">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="login" type="text" class="form-control" name="login" value="" placeholder="Login">
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="mdp" type="password" class="form-control" name="mdp" placeholder="Password">
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-sm-12 controls">
                            <button type="submit" class="btn btn-primary pull-right">Connexion</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
