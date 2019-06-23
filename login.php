<?php 

require_once("config.php");

if(isset($_POST['login'])){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
    $stmt = $db->prepare($sql);
    
    // bind parameter ke query
    $params = array(
        ":username" => $username,
        ":email" => $username
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if($user){
        // verifikasi password
        if(password_verify($password, $user["password"])){
            // buat Session
            session_start();
            $_SESSION["user"] = $user;
            // login sukses, alihkan ke halaman timeline
            header("Location: timeline.php");
        }
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

        <h4>Jelentkezzen be</h4>
        <p>Még nem regisztrált? <a href="register.php">regisztráció</a></p>

        <form action="" method="POST">

            <div class="form-group">
                <label for="username">Felhasználónév</label>
                <input class="form-control" type="text" name="username" placeholder="kissjoco12" />
            </div>


            <div class="form-group">
                <label for="password">Jelszó</label>
                <input class="form-control" type="password" name="password" placeholder="jelszo123" />
            </div>

            <input type="submit" class="btn btn-success btn-block" name="login" value="Bejelentkezés" />

        </form>
            
        </div>

        <div class="col-md-6">
            <!-- .... -->
        </div>

    </div>
</div>
    
</body>
</html>