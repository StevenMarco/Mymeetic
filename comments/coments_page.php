<?php
    $user = "root";
    $pass = "root";
    $db = new PDO("mysql:host=localhost;dbname=meetic", $user, $pass);

    $allComment = $db->prepare("SELECT * FROM commentaire ORDER BY id DESC");
    $allComment->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous">
    </script>
    <script text="text/javascript" src="core.js"></script>
    <title>Meetic</title>
</head>
<body>
    <h2>Test de commentaires: </h2>
        <h4>allez c'est parti :</h4>
            <form method="post" class="comment-form">
                <input type="text" name="pseudo" id="pseudo" placeholder="pseudo" required>
                <input type="text" name="email" id="email" placeholder="email" required>
                <br><br>
                <textarea type="text" name="message" id="message" placeholder="message" required></textarea>
                <button type="submit"><img class="form-loader" src="assets/Spinner-1s-200px.gif" width="20px" alt="chargement" hidden>
                    <span class="status">Envoie</span>
                </button>
            </form>

            <div class="comment">
                <?php
                while($reponse=$allComment->fetch(PDO::FETCH_OBJ))
                {
                ?>
                    <div class="comment-item">
                        <p>
                            <b><?= $reponse->pseudo;?> ( <?= $reponse->email; ?> )
                            </b>    
                            <p><?= $reponse->message; ?></p>
                        </p>
                    </div>
                <?php
                };
                ?>
            </div>
</body>
</html>

<?php
// <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
?>