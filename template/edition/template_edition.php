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