<?php
$user = "root";
$pass = "root";
$db = new PDO("mysql:host=localhost;dbname=mymeetic", $user, $pass);

$result = "SELECT *, FLOOR(DATEDIFF(CURDATE(), birthdate)/365) as age FROM `mymeetic`.`user` 
            LEFT JOIN user_loisirs ON user.id = user_loisirs.id_user 
            LEFT JOIN loisirs ON user_loisirs.id_loisirs = loisirs.id";

$gender = (int) $_POST['genre'];
$cities = (int) $_POST['city'];
$hobbies = (int) $_POST['hobbie'];
$old_min = (int) $_POST['old_min'];
$old_max = (int) $_POST['old_max'];

if(isset($_POST['genre']) && !empty($_POST['genre']) && (empty($_POST['city']) && empty($_POST['hobbie'])) && empty($_POST['old_min']) && empty($_POST['old_max']))
{
    $result .= " WHERE id_genre = $gender";
}
else if(isset($_POST['city']) && !empty($_POST['city']) && (empty($_POST['genre']) && empty($_POST['hobbie'])) && empty($_POST['old_min']) && empty($_POST['old_max']))
{
    $result .= " WHERE id_genre = $cities";
}
else if(isset($_POST['hobbie']) && !empty($_POST['hobbie']) && (empty($_POST['city']) && empty($_POST['genre'])) && empty($_POST['old_min']) && empty($_POST['old_max']))
{
    $result .= " WHERE id_loisirs = $hobbies";
}
else if((isset($_POST['old_min']) && !empty($_POST['old_min'])) && (isset($_POST['old_max']) && !empty($_POST['old_max'])) && (empty($_POST['city']) && empty($_POST['genre']) && empty($_POST['hobbie'])))
{
    $result .= " WHERE FLOOR(DATEDIFF(CURDATE(), birthdate)/365) BETWEEN $old_min AND $old_max";
}
else if((isset($_POST['genre']) && !empty($_POST['genre'])) && (isset($_POST['city']) && !empty($_POST['city'])) && (isset($_POST['hobbie']) && !empty($_POST['hobbie'])) && (isset($_POST['old_min']) && !empty($_POST['old_min'])) && (isset($_POST['old_max']) && !empty($_POST['old_max'])))
{
    // SELECT * FROM user WHERE FLOOR(DATEDIFF(CURDATE(), birthdate)/365) BETWEEN 23 AND 100;
    $result .= " WHERE id_genre = $gender AND id_city = $cities AND id_loisirs = $hobbies AND FLOOR(DATEDIFF(CURDATE(), birthdate)/365) BETWEEN $old_min AND $old_max";
}


$pre_result = $db->query($result);
$final = $pre_result->fetchAll();
echo json_encode($final);
