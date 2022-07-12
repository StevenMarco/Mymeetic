<?php
    $user = "root";
    $pass = "root";
    $db = new PDO("mysql:host=localhost;dbname=meetic", $user, $pass); // a modif

    sleep(2); // effet de chargement

    extract($_POST);
    if(!empty($pseudo) && !empty($email) && !empty($message))
    {
        $saveData = $db->prepare("INSERT INTO commentaire(pseudo,email,message) VALUES(?,?,?)");
        $saveData->execute(array($pseudo,$email,$message));
    ?>
        <div class="comment-item">
            <p>
                <b><?php echo $pseudo;?> ( <?php echo $email;?> )</b>    
                <p><?php echo $message;?></p>
            </p>
        </div>
    <?php
    }
?>