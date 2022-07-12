<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>MyMeetic</title>
</head>
<body>
    <nav>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="../index.php">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="inscription_index.php">inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="connexion_index.php">Connexion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="../comments/coments_page.php">TEST commentaire</a>
            </li>
    </nav>

    <br>
    <br>

    <!--formulaire-->
    <div align="center">
        <h3>Connexion</h3>
        <br><br><br>
        <form action="" method="post">
            <table>
                <!--email-->
                <tr>
                    <td>
                        <label for="email_connect">email:</label>
                    </td>
                    <td>
                        <input type="email" name="email_connect" id="email_connect" placeholder="email" value="<?= (isset($email)) ? $email : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="password_connect">password:</label>
                    </td>
                    <td>
                        <input type="password" name="password_connect" id="password_connect" placeholder="mot de passe" required>
                    </td>
                </tr>

                <tr>
    
                    <td>
                        <label for=""></label>
                    </td>
                    <td align="center">
                        <br>
                        <input type="submit" value="Connexion" name="form_connexion">
                    </td>
                </tr>
            </table>
        </form>
        <?php
            if(isset($erreur))
            {
                ?>
                    <font color='red'><?=$erreur?></font>
                <?php
            }
        ?>
    </div>
</body>
</html>