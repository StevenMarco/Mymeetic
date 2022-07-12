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