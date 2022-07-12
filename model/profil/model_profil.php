<?php
session_start();

$user = "root";
$pass = "root";
$db = new PDO("mysql:host=localhost;dbname=mymeetic", $user, $pass);

// foreach genre
$result = $db->query("SELECT * FROM `mymeetic`.`genre`");
$genres = $result->fetchAll();
// foreach city
$result = $db->query("SELECT * FROM `mymeetic`.`city`");
$cities = $result->fetchAll();
// foreach hobbies
$result = $db->query("SELECT * FROM `mymeetic`.`loisirs`");
$hobbies = $result->fetchAll();

    // SET user
    $get_id = intval($_SESSION['id']);
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



    $requete_all_user = $db->query("SELECT * FROM `user`");
    $user_all_info = $requete_all_user->fetchAll();




    // DELETE sans DELETE 
    if(isset($_POST["delete"]) && !empty($_POST["delete"]))
    {
        if(($_POST["delete"] === $_POST["confirm_delete"]) && ($_POST["delete"] && $_POST["confirm_delete"] == "Delete sans delete !"))
        {

            $result = $db->query("UPDATE user_loisirs SET 
            id_user = 7, 
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