<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous">
    </script>
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
        Genre = <?php echo $user_genre['sexe'];?>
        <br>
        Email = <?php echo $user_info['email'];?>
        <br>
        Hobbie(s) = <?php echo $user_hobbies['loisir'];?>
        <br>
    </div>

    <br><br><br><br>

    <div>
        <form class="profil_form" action="" method="POST">
            <label for="genre">Genre :</label>
                <select name="genre" id="genre">
                    <option value="">-></option>
                    <?php
                        foreach($genres as $genre)
                        {
                            echo '<option value="' . $genre['id'] . '">' . $genre['sexe'] . '</option>';
                        }
                    ?>
                </select>
            <label for="city">City :</label>
                <select name="city" id="city">
                    <option value="">-></option>
                        <?php
                            foreach($cities as $city)
                            {
                                echo '<option value="' . $city['id'] . '">' . $city['city'] . '</option>';
                            }
                        ?>
                </select>
            <label for="hobbie">Hobbies :</label>
                <select name="hobbie" id="hobbie">
                    <option value="">-></option>
                        <?php
                            foreach($hobbies as $hobbie)
                            {
                                echo '<option value="' . $hobbie['id'] . '">' . $hobbie['loisir'] . '</option>';
                            }
                        ?>
                </select>
                <br>
            <label for="old_min">Age :</label>
                <input type="number" name="old_min" id="old_min" placeholder="minimum old..">
                <input type="number" name="old_max" id="old_max" placeholder="maximum old..">
            <input type="submit" value="search">
        </form>
        
    </div>
    <div class="search">
        <ul >
            <li class="id_search">Résultat :</li>
        </ul>
    </div>
    
    <!-- <button id="toto" type="button">Add to favorites</button> -->
    <!-- <script type="text/javascript">
        $( "#toto" ).click(function() 
        {
            let url = 'http://localhost/W-PHP-501-NCE-1-1-mymeetic-steven.marco/controller/toto.php';
                    let xhttp = new XMLHttpRequest();
                    xhttp.onload = function() 
                    {
                        let fLen = JSON.parse(xhttp.response).length;

                        let text = "<ul>";
                        for (let i = 0; i < fLen; i++) 
                        {
                            text += "<li>" + JSON.parse(xhttp.response)[i][3] + "</li>";
                        }
                        console.log(text)
                        $(".search").append( text );

                        console.log(JSON.parse(xhttp.response)[1]);

                    } 
                    xhttp.open("GET", url);
                    xhttp.send();

        });
    </script> -->

    <script type="text/javascript">
        $(".profil_form").on('submit', function(e)
        {
            e.preventDefault();
            
            $(".add_search").remove();
            let data = new FormData(this);
            let xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() 
            {
                if(this.readyState == 4 && this.status == 200)
                {
                    
                    console.log(this.response);
                    let result = xhttp.response;
                    let res_lenght = JSON.parse(xhttp.response).length;

                    let text = "<ul class ='add_search'>";
                    for (let i = 0; i < res_lenght; i++) 
                    {
                        text += "<li> firstname : " + JSON.parse(result)[i]['firstname'] + 
                        "</li> <li> lastname : " + JSON.parse(result)[i]['lastname'] + 
                        "</li> <li> birthdate : " + JSON.parse(result)[i]['birthdate'] + "</li> <br>";
                    }
                        $(".search").append(text);
        
                    console.log(JSON.parse(result)[0]['firstname']); // dynamique
                }
                else if(this.readyState == 4)
                {
                    alert("aie, une erreur est survenue");
                }
            }; 
            let url = '../model/profil/search.php';
            xhttp.open("POST", url);
            xhttp.responsetype = "json";
            xhttp.send(data);

            return false;
        })
    </script>
    
    <br>
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