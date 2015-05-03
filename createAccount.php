<?php
session_start();
include('includeClass.php');
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Com'App - Création de compte</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
        <?php
        //Vérification des informations saisies par l'utilisateur pour créer son compte
        if ($_POST) {
            if (isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['email']) && isset($_POST['name']) && isset($_POST['firstName'])) {
                if (User::verifyPassword($_POST['password'])) {
                    if (sha1($_POST['password']) == sha1($_POST['password2'])) {
                        $email = $_POST['email'];
                        $password = sha1($_POST['password']);
                        $name = strtoupper($_POST['name']);
                        $firstName = ucfirst(strtolower($_POST['firstName']));
                        $createUser = User::createUser($email, $password, $name, $firstName);
                        if ($createUser) {
                            $message = '<div class = "alert alert-success">
                                            Votre compte à été crée.<br>
                                            <a href="login.php"><b>Retour à la page d\'authentification</b></a>.
                                        </div>';
                        }
                    } else {
                        $message = '<div class = "alert alert-danger">
                                            Les deux mots de passe saisies ne sont pas identiques.
                                        </div>';
                    }
                }else{
                    $message = '<div class = "alert alert-danger">
                                            Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule et doit être comprises entre 7 et 20 caractères.
                                        </div>';
                }
            } else {
                $message = '<div class = "alert alert-danger">
                                            Vous devez remplir tous les champs pour valider votre inscription.
                                        </div>';
            }
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <h1 class="text-center"><strong>Com'App</strong></h1>
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Créer votre compte !</h3>
                        </div>
<?php
//Affichage du message d'erreur si il y a une erreur
if (isset($message)) {
    echo $message;
}
?>
                        <span class="label label-info">Tous les champs doivent être remplies</span>
                        <div class="panel-body">

                            <form role="form" action="createAccount.php" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Nom de famille" name="name" type="text" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Prénom" name="firstName" type="text" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Mot de Passe" name="password" type="password" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Re-saisissez votre mot de passe" name="password2" type="password" value="">
                                    </div>

                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Création"><br>
                                    <div class="text-left">
                                        <a href="login.php">Retour à la page de connexion.</a>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>

    </body>

</html>