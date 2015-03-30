<?php
session_start();
include('includeClass.php')
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Com'App - Authentification</title>

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
        if ($_POST) {
            //Récuperation des identifiants
            $email = $_POST['email'];
            $password = sha1($_POST['password']);

            //Vérification des identifiants
            $results = User::verifyUser($email, $password);

            if (sizeof($results) == 0) {
                $passwordOk = '<div class = "alert alert-danger">
                                    Votre identifiant et/ou mot de passe sont érronés.
                                </div>';
            } else {
                $_SESSION['connect'] = true;
                $_SESSION['firstName'] = $results[0]['firstName'];
                $_SESSION['name'] = $results[0]['name'];
                $_SESSION['userId'] = $results[0]['id'];
                $_SESSION['email'] = $results[0]['email'];
                header('Location: index.php');
            }
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <h1 class="text-center"><strong>Com'App</strong></h1>
                    <div class="login-panel panel panel-default">
                        <?php if (isset($passwordOk)) {
                            echo $passwordOk;
                        } ?>
                        <div class="panel-heading">
                            <h3 class="panel-title">Connectez vous !</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="login.php" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Mot de Passe" name="password" type="password" value="">
                                    </div>
                                    <!--<div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Se souvenir de moi
                                        </label>
                                    </div>-->
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Connexion"><br>
                                    <div class="text-left">
                                        Vous n'avez pas de compte ? <a href="createAccount.php">Créez-en un.</a> 
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