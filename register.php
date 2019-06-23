<?php

require_once("config.php");

if(isset($_POST['register'])){

    // Bemeneti adat szűrés
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);


    // Beszuras
    $sql = "INSERT INTO users (name, username, email, password) 
            VALUES (:name, :username, :email, :password)";
    $stmt = $db->prepare($sql);

    // parameter lekerdezese
    $params = array(
        ":name" => $name,
        ":username" => $username,
        ":password" => $password,
        ":email" => $email
    );

    // lekérdezés végrehajtása az adatbázisba mentéshez
    $saved = $stmt->execute($params);


    // ha a lekérdezés sikeresen mentésre kerül, akkor a felhasználó regisztrálódik
    // majd váltson a bejelentkezési oldalra
    if($saved)
    {

    require 'PHPMailerAutoload.php';

    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->IsSMTP();                                          // SMTP-n keresztuli kuldes
    $mail->Host     = 'smtp.rackhost.hu';                     // SMTP szerverek
    $mail->SMTPAuth = true;                                   // SMTP

    $mail->Username = 'ugyfelszolgalat@jolenne.hu';            // SMTP felhasználo
    $mail->Password = 'kampecaSS88';                               // SMTP jelszo

    $mail->From     = 'ugyfelszolgalat@jolenne.hu';            // Felado e-mail cime
    $mail->FromName = 'Jólenne Ügyfélszolgálat';                // Felado neve
    $mail->AddAddress($email, $name);         // Cimzett es neve
    //$mail->AddAddress($email);                      // Meg egy cimzett
    $mail->AddReplyTo('ugyfelszolgalat@jolenne.hu', 'Information'); // Valaszlevel ide

    $mail->WordWrap = 80;                                     // Sortores allitasa
    //$mail->AddAttachment('/var/tmp/file.tar.gz');             // Csatolas
    //$mail->AddAttachment('/tmp/image.jpg', 'new.jpg');        // Csatolas mas neven
    $mail->IsHTML(true);                                      // Kuldes HTML-kent

    $mail->Subject = 'Értesítő a regisztrációról';                   // A level targya
    $mail->Body = '<b>A felhasználói fiókod készen áll!</b><br> Felhasználónév: '.$username.' E-mail: '.$email.' <br> Help: ugyfelszolgalat@jolenne.hu' ;        // A level tartalma
    $mail->AltBody = 'This is the text-only body';            // A level szoveges tartalma

    if (!$mail->Send()) {
      echo 'A levél nem került elküldésre';
      echo 'A felmerült hiba: ' . $mail->ErrorInfo;
      exit;
    }

    echo 'A levelet sikeresen kiküldtük';
     header("Location: login.php");
     }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jó lenne ,ha...</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">

        <p>&larr; <a href="index.php">Kezdőlap</a>

        <h4>Könnyen és egyszerűen be regisztrálhatsz</h4>
        <p>Van már Accountod? <a href="login.php">Bejelentkezés</a></p>

        <form action="" method="POST">

            <div class="form-group">
                <label for="name">Teljes neved</label>
                <input class="form-control" type="text" name="name" placeholder="Kiss József" />
            </div>

            <div class="form-group">
                <label for="username">Felhasználónév</label>
                <input class="form-control" type="text" name="username" placeholder="kissjoco12" />
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" placeholder="kissjoco12@pelda.hu" />
            </div>

            <div class="form-group">
                <label for="password">Jelszó</label>
                <input class="form-control" type="password" name="password" placeholder="jelszo123" />
            </div>

            <input type="submit" class="btn btn-success btn-block" name="register" value="Regisztráció" />

        </form>
            
        </div>

        <div class="col-md-6">
            <img class="img img-responsive" src="img/connect.png" />
        </div>

    </div>
</div>

</body>
</html>