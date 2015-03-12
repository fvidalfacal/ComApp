<?php
session_start();
session_destroy();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="Refresh" content="0;URL=index.php"/>
        <title>Redirection</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="span12">
                    <p class="text-info"> Vous avez été déconnecté(e).</p>
                    <img src="images/chargement.gif" title="Déconnexion en cours ..." />
                </div>
            </div>
        </div>
    </body>
</html>
