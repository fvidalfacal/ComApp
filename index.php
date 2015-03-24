<?php
session_start();
if (!isset($_SESSION['connect']) || $_SESSION['connect'] == false) {
    header("Location: login.php");
}
include ('includeClass.php');
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Com'App - Accueil </title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="css/plugins/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="css/plugins/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><?php echo $_SESSION['firstName'] . ' ' . $_SESSION['name']; ?></a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="index.php?profil"><i class="fa fa-user fa-fw"></i> Profil utilisateur</a>
                            </li>
                            <li><a href="index.php?settings"><i class="fa fa-gear fa-fw"></i> Paramètres</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Déconnexion</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->


                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a class="active" href="index.php"><i class="fa fa-dashboard fa-fw"></i> Accueil</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tags fa-fw"></i> Groupe(s)<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <?php
                                    $user = new User($_SESSION['userId']);
                                    echo $user->getGroups();
                                    ?>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>

                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>


            <!-- AFFICHAGE DE LA PAGE DU GROUPE SÉLECTIONNÉ -->
            <?php
            if (isset($_GET['group'])) {

                $groupe = new Group($_GET['group']);
                $nomGroupe = $groupe->getName();

                $messages = Message::getMessagesByIdHashtag($_GET['group'], $_SESSION['userId']);
                ?>

                <div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"><i class="fa fa-slack"></i><?php echo $nomGroupe; ?></h1>
                        </div>
                    </div>
                    <?php
                    if ($messages) {
                        ?>
                        <table class="table table-striped table-bordered table-hover dataTable test no-footer">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Message</th>
                                    <th>Auteur</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $messages; ?>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        echo '<p class="bg-danger text-danger">Il n\'y a pas de message pour ce groupe.</p>';
                    }
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="page-header">Ajout d'un message</h3>
                        </div>
                        <div  class="jMax col-lg-3 col-md-6">
                            <form class="form-inline" role="form" action="addMessage.php?from=<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                                <div class="text-right"></div>
                                <div class="form-group">
                                    <textarea name="content" rows=3 cols=80 maxlength="255" onkeypress="$(this).parent().prev().html((255 - $(this).val().length) + '/255')">#<?php echo $nomGroupe; ?></textarea>
                                </div>
                                <input type="submit" class="btn btn-default" value="Ajouter un message">
                            </form>
                        </div>
                    </div>

                </div>

                <!-- /.AFFICHAGE DE LA PAGE DU GROUPE SÉLECTIONNÉ -->


                <!-- GESTION DU PROFIL UTILISATEUR -->
                <?php
            } elseif (isset($_GET['profil'])) {
                ?>

                <div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Gestion du compte</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <form role="form" action="profilchange.php" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Votre prénom" name="firstName" type="text" value="<?php echo $_SESSION['firstName']; ?>"></input>
                                    </div>
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Changer votre prénom">
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <form role="form" action="profilchange.php" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Votre nom de famille" name="name" type="text" value="<?php echo $_SESSION['name']; ?>"></input>
                                    </div>
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Changer votre nom de famille">
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <form role="form" action="profilchange.php" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Votre adresse E-Mail actuelle" name="oldEmail" type="email" value="<?php echo $_SESSION['email']; ?>"></input>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Votre nouvelle adresse E-Mail" name="newEmail1" type="email" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Votre nouvelle adresse E-Mail" name="newEmail2" type="email" value="">
                                    </div>
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Changer votre E-Mail">
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <form role="form" action="profilchange.php" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Mot de passe actuel" name="oldPassword" type="password" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Votre nouveau mot de passe" name="newPassword1" type="password" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Votre nouveau mot de passe" name="newPassword2" type="password" value="">
                                    </div>
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Changer votre mot de passe">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.GESTION DU PROFIL UTILISATEUR -->


                <!-- PARAMÈTRES DES GROUPES -->
                <?php
            } else {
                ?>
                <div id="page-wrapper">
                    <div class="row">

                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="page-header">Liste de tous les hashtags</h1>
                            </div>
                            <?php
                            $allGroups = Group::getAllGroups();
                            foreach ($allGroups as $group) {
                                ?>
                                <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-comments fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge"><i class="fa fa-slack"></i><?php echo $group['name']; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="index.php?group=<?php echo $group['id']; ?>">
                                            <div class="panel-footer">
                                                <span class="pull-left">Voir le groupe</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <!-- /.col-lg-12 -->
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="page-header">Ajout d'un message</h3>
                            </div>
                            <div  class="jMax col-lg-3 col-md-6">
                                <form class="form-inline" role="form" action="addMessage.php?from=<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                                    <div class="text-right"></div>
                                    <div class="form-group">
                                        <textarea name="content" rows=3 cols=80 maxlength="255" onkeypress="$(this).parent().prev().html((255 - $(this).val().length) + '/255')"></textarea>
                                    </div>
                                    <input type="submit" class="btn btn-default" value="Ajouter un message">
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                    <div class="row">


                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.ACCUEIL -->
                <!-- /#page-wrapper -->
                <?php
            }
            ?>
        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="js/plugins/morris/raphael.min.js"></script>


        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>


        <!-- DataTable JavaScript -->
        <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

        <!-- Initialisation de DataTable -->
        <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('.dataTable').DataTable({
                                                "columns": [
                                                    {"width": "10%"},
                                                    null,
                                                    {"width": "15%"},
                                                    {"width": "5%"}
                                                ],
                                                "order": [[0, "desc"]],
                                                "language": {
                                                    "url"
                                                            : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                                                }
                                            });
                                        });
        </script>
    </body>

</html>
