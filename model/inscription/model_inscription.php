<?php

$user = "root";
$pass = "root";
$db = new PDO("mysql:host=localhost;dbname=mymeetic", $user, $pass);

$result = $db->query("SELECT * FROM `mymeetic`.`genre`");
$genres = $result->fetchAll();

$result = $db->query("SELECT * FROM `mymeetic`.`city`");
$cities = $result->fetchAll();

$result = $db->query("SELECT * FROM `mymeetic`.`loisirs`");
$hobbies = $result->fetchAll();

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