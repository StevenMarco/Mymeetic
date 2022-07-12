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
}
else
{
    header("Location: connexion_index.php");
}
?>