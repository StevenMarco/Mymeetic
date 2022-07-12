
<tr>
<td>
    <label for="hobbies">Loisirs:</label>
</td>
<td>
    <fieldset>
        <?php
            $result = $db->query("SELECT * FROM `mymeetic`.`loisirs`");
            $hobbies = $result->fetchAll();
            foreach($hobbies as $hobbie)
            {
        ?>
                <div>
                    <input type="checkbox" class="hobbies" name='insert_hobbie[]' value="<?=$hobbie['id']?>">
                    <label for='insert_hobbie[]'><?=$hobbie['loisir']?></label>
                </div>
        <?php
            }
        ?>
    <fieldset>
</td>
</tr>



<?php

// si id isset alors ... else ...

                if(isset($_SESSION['id']) && $user_info['id'] == $_SESSION['id'])
                {
                    ?>
                    <a href="edition_index.php">Editer mon profil</a>
                    <a href="deconnexion_index.php">Deconnexion</a>
                    <?php
                }
?>

<!--                                             INSCRIPTION                                                      -->

<?php

$user = "root";
$pass = "root";
$db = new PDO("mysql:host=localhost;dbname=mymeetic", $user, $pass);

    // php formulaire
    if((isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['password']) && !empty($_POST['password'])))
    {
        // security
        $email = htmlspecialchars($_POST['email']);
        $confirm_email = htmlspecialchars($_POST['confirm_email']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $genre = htmlspecialchars($_POST['genre']); // modif
        $city = htmlspecialchars($_POST['city']); // modif
        $hobbies = htmlspecialchars($_POST['hobbies']); // modif
        $address = htmlspecialchars($_POST['address']);
        $birthdate = htmlspecialchars($_POST['birthdate']);
        $zipcode = htmlspecialchars($_POST['zipcode']);
        $password = sha1($_POST['password']);
        $confirm_password = sha1($_POST['confirm_password']);
            if(isset($birthdate) && !empty($birthdate))
            {
                $birthdate_var = $birthdate;
                $today = date("Y-m-d");
                $diff = date_diff(date_create($birthdate_var), date_create($today)); 
                $verif_birthdate = (int) $diff->format('%y');

                if($verif_birthdate >= 18)
                {
                    if($email == $confirm_email)
                    {
                        if(filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                            if($password == $confirm_password)
                            {
                                $requete_mail = $db->query("SELECT COUNT(*) AS 'email' FROM user WHERE email = '" . $email . "'");
                                $requete = $requete_mail->fetch(PDO::FETCH_OBJ);
                                $mail_exist = $requete->email;
                                if($mail_exist == 0)
                                {
                                    // INSERT INTO user
                                    $result = $db->query("INSERT INTO user (firstname, lastname, email, birthdate, address, zipcode, password, id_genre, id_city) 
                                                        VALUES(
                                                            '" . $firstname . "', 
                                                            '" . $lastname . "', 
                                                            '" . $email . "', 
                                                            '" . $birthdate . "', 
                                                            '" . $address . "', 
                                                            '" . $zipcode . "', 
                                                            '" . $password . "', 
                                                            '" . $genre . "', 
                                                            '" . $city . "');");
                                    $insert = $result->fetch(PDO::FETCH_OBJ);

                                    // add ID
                                    $result = $db->query("SELECT * FROM user ORDER BY id DESC LIMIT 1");
                                    $id = $result->fetch(PDO::FETCH_OBJ);
                                    $new_id = $id->id;
                                    // INSERT INTO Hobbie
                                    $requete_hobbie = $db->query("INSERT INTO user_loisirs (id_user, id_loisirs) 
                                                                    VALUES (" . $new_id . ", " . $hobbies . ")");
                                    $requete = $requete_hobbie->fetch(PDO::FETCH_OBJ);

                                    $_SESSION['compte_valide'] = "Votre compte a bien été créer. Merci de votre inscription.";
                                    header('Location: connexion_index.php');
                                }
                                else
                                {
                                    $erreur = "Cette adresse mail est déja utilisé.";
                                }
                            }
                            else
                            {
                                $erreur = "Attention, votre mot de passe ne correspond pas avec la comfirmation.";
                            }
                        }
                        else
                        {
                            $erreur = "Attention, votre adresse mail n'est pas valide, veuillez la vérifier.";
                        }
                    }
                    else
                    {
                        $erreur = "Attention, votre adresse mail ne correspond pas avec la comfirmation.";
                    }
                }    
                else
                {
                    $erreur = "Désolez mais vous ne resptectez l'âge minimum demandé.";
                    //fun vers page enfant
                }
            }    
            else
            {
                $erreur = "Attention, votre date de naissance est obligatoire. Veuillez la renseigner.";
            }
        }
        else
        {
            $erreur = "Veuillez remplir tous les champs.";
        }
    ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>MyMeetic</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> -->
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
        <h3>Inscription</h3>
        <br><br><br>
        <form action="" method="post">
            <table>
                <!--email-->
                <tr>
                    <td>
                        <label for="email">email:</label>
                    </td>
                    <td>
                        <input type="email" name="email" id="email" placeholder="email" value="<?= (isset($email)) ? $email : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="confirm_email">confirm email:</label>
                    </td>
                    <td>
                        <input type="email" name="confirm_email" id="confirm_email" placeholder="confirm email" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="firstname">firstname:</label>
                    </td>
                    <td>
                        <input type="text" name="firstname" id="firstname" placeholder="firstname" value="<?= (isset($firstname)) ? $firstname : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="lastname">lastname:</label>
                    </td>
                    <td>
                        <input type="text" name="lastname" id="lastname" placeholder="lastname" value="<?= (isset($lastname)) ? $lastname : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="genre">genre:</label>
                    </td>
                    <td>
                        <select name="genre">
                            <option value="">-></option>
                                <?php
                                    $result = $db->query("SELECT * FROM `mymeetic`.`genre`");
                                    $genres = $result->fetchAll();
                                    foreach($genres as $genre)
                                    {
                                        echo '<option value="' . $genre['id'] . '">' . $genre['sexe'] . '</option>';
                                    }
                                ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="birthdate">birthdate:</label>
                    </td>
                    <td> 
                        <input type="date" name="birthdate" id="birthdate" required>
                    </td> 
                </tr>

                <tr>
                    <td>
                        <label for="address">address:</label>
                    </td>
                    <td>
                        <input type="text" name="address" id="address" placeholder="address" value="<?= (isset($address)) ? $address : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="zipcode">zipcode:</label>
                    </td>
                    <td>
                        <input type="number" name="zipcode" id="zipcode" placeholder="zipcode ex:09800" value="<?= (isset($zipcode)) ? $zipcode : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="city">city:</label>
                    </td>
                    <td>
                        <select name="city">
                            <option value="">-></option>
                                <?php
                                    $result = $db->query("SELECT * FROM `mymeetic`.`city`");
                                    $cities = $result->fetchAll();
                                    foreach($cities as $city)
                                    {
                                        echo '<option value="' . $city['id'] . '">' . $city['city'] . '</option>';
                                    }
                                ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="password">password:</label>
                    </td>
                    <td>
                        <input type="password" name="password" id="password" placeholder="mot de passe" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="confirm_password">confirm password:</label>
                    </td>
                    <td>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="confirmer votre mot de passe" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="hobbies">Loisirs:</label>
                    </td>
                    <td>
                        <fieldset>
                            <?php
                                $result = $db->query("SELECT * FROM `mymeetic`.`loisirs`");
                                $hobbies = $result->fetchAll();
                                foreach($hobbies as $hobbie)
                                {
                            ?>
                                    <div>
                                        <input type="radio" class="hobbies" name='hobbies' value="<?=$hobbie['id']?>">
                                        <label for='hobbies'><?=$hobbie['loisir']?></label>
                                    </div>
                            <?php
                                }
                            ?>
                        <fieldset>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for=""></label>
                    </td>
                    <td align="center">
                        <br>
                        <input type="reset" value="reset">
                        <input type="submit" value="inscripion" name="form_inscription">
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
        <br>
        <button name="connexion_button" id="connexion_button" value="Connexion"><a href="connexion_index.php">Connexion</a></button>
    </div>
</body>
</html>



<!--                                                         CONNEXION                            -->

<?php
session_start();

$user = "root";
$pass = "root";
$db = new PDO("mysql:host=localhost;dbname=mymeetic", $user, $pass);


    if(isset($_POST['form_connexion']))
    {
        $email_connect = htmlspecialchars($_POST['email_connect']);
        $password_connect = sha1($_POST['password_connect']);

        if(!empty($email_connect) && !empty($password_connect))
        {
            $requete_user = $db->query("SELECT COUNT(*) AS connexion FROM user 
                                        WHERE email = '" . $email_connect . 
                                        "' AND password = '" . $password_connect . "'");
            $requete = $requete_user->fetch(PDO::FETCH_OBJ);
            $user_exist = $requete->connexion;
            if($user_exist == 1)
            {
                $info = $db->query("SELECT * FROM user WHERE email = '" . $email_connect . "' AND password = '" . $password_connect . "'");
                $user_info = $info->fetch();
                $_SESSION['id'] = $user_info['id'];
                $_SESSION['email'] = $user_info['email'];
                $_SESSION['firstname'] = $user_info['firstname'];
                $_SESSION['lastname'] = $user_info['lastname'];
                $_SESSION['birthdate'] = $user_info['birthdate'];
                $_SESSION['address'] = $user_info['address'];
                $_SESSION['zipcode'] = $user_info['zipcode'];
                $_SESSION['id_genre'] = $user_info['id_genre'];
                $_SESSION['id_city'] = $user_info['id_city'];

                header("Location: profil_index.php?id=" . $_SESSION['id']);
            }
            else
            {
                $erreur = "Une erreur d'identifiant ou mot de passe est survenu";
            }
        }
        else
        {
            $erreur = "Tous les champs ne son pas rempli";
        }
    }

?>

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

<!--                                                 EDITION                                       -->

<?php
session_start();

$user = "root";
$pass = "root";
$db = new PDO("mysql:host=localhost;dbname=mymeetic", $user, $pass);

if(isset($_SESSION['id']))
{
    $requete_user = $db->query("SELECT * FROM `user` WHERE id = '" . $_SESSION['id'] . "'");
    $user_info = $requete_user->fetch();

        if((isset($_POST['new_email']) && !empty($_POST['new_email'])) && ($_POST['new_email'] != $user_info['email']))
        {
            $new_email = htmlspecialchars($_POST['new_email']);
            $insert_email = $db->query("UPDATE `user` SET email = '" . $new_email . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_email->fetch();
            header("Location: profil_index.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_firstname']) && !empty($_POST['new_firstname'])) && ($_POST['new_firstname'] != $user_info['firstname']))
        {
            $new_firstname = htmlspecialchars($_POST['new_firstname']);
            $insert_firstname = $db->query("UPDATE `user` SET firstname = '" . $new_firstname . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_firstname->fetch();
            header("Location: profil_index.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_lastname']) && !empty($_POST['new_lastname'])) && ($_POST['new_lastname'] != $user_info['lastname']))
        {
            $new_lastname = htmlspecialchars($_POST['new_lastname']);
            $insert_lastname = $db->query("UPDATE `user` SET lastname = '" . $new_lastname . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_lastname->fetch();
            header("Location: profil_index.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_address']) && !empty($_POST['new_address'])) && ($_POST['new_address'] != $user_info['address']))
        {
            $new_address = htmlspecialchars($_POST['new_address']);
            $insert_address = $db->query("UPDATE `user` SET address = '" . $new_address . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_address->fetch();
            header("Location: profil_index.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_zipcode']) && !empty($_POST['new_zipcode'])) && ($_POST['new_zipcode'] != $user_info['zipcode']))
        {
            $new_zipcode = htmlspecialchars($_POST['new_zipcode']);
            $insert_zipcode = $db->query("UPDATE `user` SET zipcode = '" . $new_zipcode . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_zipcode->fetch();
            header("Location: profil_index.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_city']) && !empty($_POST['new_city'])) && ($_POST['new_city'] != $user_info['city']))
        {
            $new_city = htmlspecialchars($_POST['new_city']);
            $insert_city = $db->query("UPDATE `user` SET city = '" . $new_city . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_city->fetch();
            header("Location: profil_index.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_genre']) && !empty($_POST['new_genre'])) && ($_POST['new_genre'] != $user_info['genre']))
        {
            $new_genre = htmlspecialchars($_POST['new_genre']);
            $insert_genre = $db->query("UPDATE `user` SET id_genre = '" . $new_email . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_genre->fetch();
            header("Location: profil_index.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_city']) && !empty($_POST['new_city'])) && ($_POST['new_city'] != $user_info['city']))
        {
            $new_city = htmlspecialchars($_POST['new_city']);
            $insert_city = $db->query("UPDATE `user` SET id_city = '" . $new_city . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_city->fetch();
            header("Location: profil_index.php?id=" . $_SESSION['id']);
        }

        if((isset($_POST['new_password']) && !empty($_POST['new_password'])) && (isset($_POST['confirm_new_password']) && !empty($_POST['confirm_new_password'])))
        {
            $mdp1 = sha1($_POST['new_password']);
            $mdp2 = sha1($_POST['confirm_new_password']);

            if($mdp1 == $mdp2)
            {
                $insert_password = $db->query("UPDATE `user` SET password = '" . $mdp1 . "' WHERE id = '" . $_SESSION['id'] . "'");
                $user_info = $insert_password->fetch();
                header("Location: profil_index.php?id=" . $_SESSION['id']);

            }
            else
            {
                $erreur = "Les mots de passe de sont pas identiques";
            }
        }
?>
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
        <div align="left">
            <h3>Edition du profil</h3>
            <br><br><br>
            <form action="" method="post">
                <label for="new_email">Email :</label>
                    <input type="email" name="new_email" id="" placeholder="new_email" value="<?php echo $user_info['email']?>"> <br> </br>
                <label for="new_firstname">Firstname :</label>
                    <input type="text" name="new_firstname" id="" placeholder="new_firstname" value="<?php echo $user_info['firstname']?>"> <br> </br>
                <label for="new_lastname">Lastname :</label>
                    <input type="text" name="new_lastname" id="" placeholder="new_lastname" value="<?php echo $user_info['lastname']?>"> <br> </br>
                <label for="new_birthdate">Birthdate :</label>
                    <input type="date" name="new_birthdate" id="" value="<?php echo $user_info['birthdate']?>"> <br> </br>
                <label for="new_address">Address :</label>
                    <input type="text" name="new_address" id="" placeholder="new_address" value="<?php echo $user_info['address']?>"> <br> </br>
                <label for="new_zipcode">Zipcode :</label>
                    <input type="number" name="new_zipcode" id="" placeholder="new_zipcode" value="<?php echo $user_info['zipcode']?>"> <br> </br>
                
                
                <label for="new_genre">genre:</label>
                    <select name="new_genre">
                            <option value="">-></option>
                                <?php
                                    $result = $db->query("SELECT * FROM `mymeetic`.`genre`");
                                    $genres = $result->fetchAll();
                                    foreach($genres as $genre)
                                    {
                                        echo '<option value="' . $genre['id'] . '">' . $genre['sexe'] . '</option>';
                                    }
                                ?>
                    </select>
                    <br> </br>

                <label for="new_city">city:</label>
                    <select name="new_city">
                        <option value="">-></option>
                            <?php
                                $result = $db->query("SELECT * FROM `mymeetic`.`city`");
                                $cities = $result->fetchAll();
                                foreach($cities as $city)
                                {
                                    echo '<option value="' . $city['id'] . '">' . $city['city'] . '</option>';
                                }
                            ?>
                    </select>
                    <br> </br>
                
                <label for="new_password">Password :</label>
                    <input type="password" name="new_password" id="" placeholder="new_password"> <br> </br>
                <label for="confirm_new_password">Confirm Password :</label>
                    <input type="password" name="confirm_new_password" id="" placeholder="confirm new_password"> <br> </br>
                <input type="submit" value="Mise à jour du profil">
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
<?php
}
else
{
    header("Location: connexion_index.php");
}
?>


<!--                                                    PROFIL                                              -->

<?php
session_start();

$user = "root";
$pass = "root";
$db = new PDO("mysql:host=localhost;dbname=mymeetic", $user, $pass);




if(isset($_GET['id']) && $_GET['id'] > 0)
{
    // SET user
    $get_id = intval($_GET['id']);
    $requete_user = $db->query("SELECT * FROM `user` WHERE id = '" . $get_id . "'");
    $user_info = $requete_user->fetch();
    // SET sexe
    $info_genre = $db->query("SELECT * FROM genre WHERE id =" . $_SESSION['id_genre']);
    $user_genre = $info_genre->fetch();
    $_SESSION['sexe'] = $user_genre['sexe'];  
    // SET city
    $info = $db->query("SELECT * FROM city WHERE id =" . $_SESSION['id_city']);
    $user_city = $info->fetch();
    $_SESSION['city'] = $user_city['city'];
    // SET hobbies
    $info = $db->query("SELECT * FROM user_loisirs WHERE id_user =" . $_SESSION['id']);
    $user_hobbies = $info->fetch();
    $id_loisirs = (int) $user_hobbies['id_loisirs'];
    $info = $db->query("SELECT * FROM loisirs WHERE id = " . $id_loisirs);
    $user_hobbies = $info->fetch();



    if(isset($_POST["delete"]) && !empty($_POST["delete"]))
    {
        if(($_POST["delete"] === $_POST["confirm_delete"]) && ($_POST["delete"] && $_POST["confirm_delete"] == "Delete sans delete !"))
        {

            $result = $db->query("UPDATE user_loisirs SET 
            id_user = null, 
            id_loisirs = null 
            WHERE id_user = $get_id");
            $test = $result->fetch(PDO::FETCH_OBJ);
            


            $result = $db->query("UPDATE user SET 
            firstname = null, 
            lastname = null, 
            email = null, 
            birthdate = null, 
            address = null, 
            zipcode = null, 
            password = null, 
            id_genre = null, 
            id_city = null 
            WHERE id = $get_id AND email = '" . $_SESSION['email'] . "' AND lastname = '" . $_SESSION['lastname'] . "'");
            $test = $result->fetch(PDO::FETCH_OBJ);

            header('Location: ../index.php');
        }
    }
?>


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
                <?php
                if(isset($_SESSION['id']) && $user_info['id'] == $_SESSION['id'])
                {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="edition_index.php">Editer mon profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="deconnexion_index.php">Deconnexion</a>
                    </li>
                    <?php
                }
                else
                {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="connexion_index.php">Connexion</a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link"  href="../comments/coments_page.php">TEST commentaire</a>
                </li>
        </nav>
        <br>
        <!--formulaire-->
        <div>
            <h4>Profil de <?php echo $user_info['lastname'] . ", " . $user_info['firstname'];?> :</h4>
            <br>
            Lastname = <?php echo $user_info['lastname'];?>
            <br>
            Firstname = <?php echo $user_info['firstname'];?>
            <br>
            Birthdate = <?php echo $user_info['birthdate'];?>
            <br>
            Genre = <?php echo $user_genre['sexe'];?> <!--modif-->
            <br>
            Email = <?php echo $user_info['email'];?>
            <br>
            Hobbie(s) = <?php echo $user_hobbies['loisir'];?> <!--modif-->
            <br>
        </div>

        <div>
            <h5>Supprimer le compte:</h5>
            <p>(Attention toute suppression est défintive !)</p>
            <form action="" method="post">
                <label for="">Veuillez écrire exactement : "Delete sans delete !" </label> <br>
                <input type="text" name="delete" id="delete" placeholder="Delete sans delete !"> <br>
                <input type="text" name="confirm_delete" id="confirm_delete" placeholder="Repeat text"> <br>
                <input type="submit" value="Supprimer votre compte (Sans le DELETE !)">
            </form>
        </div>
    </body>
</html>

<?php
}
else
{

}
?>





<button type="button" onclick="loadDoc()">Request data</button>
<p id="demo"></p>

<script>
function loadDoc() {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
	console.log(this.responseText);
  } 
  xhttp.open("POST", "http://localhost/W-PHP-501-NCE-1-1-mymeetic-steven.marco/controller/connexion_index.php");
  xhttp.send();
}
</script>


<script>
            $(".profil_form").on('submit', function(e)
        {
            e.preventDefault();

            let url = '../model/profil/search.php';
            let xhttp = new XMLHttpRequest();
            xhttp.onload = function() 
            {
                $(".id_search2").text("please..");
                $(".id_search").text(xhttp.responseText);
                console.log(this.responseText);
                // document.getElementsByClassName("id_search").innerHTML = xhttp.responseText;
            } 
            xhttp.open("get", url, true);
            xhttp.send();
            // console.log(url);
        })
</script>