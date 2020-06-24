<?php
 
session_start();
include 'inc/database.php';
 
if (isset($_SESSION['userEmail'])) {
    header('Location:index.php');
}
 
if (isset($_POST['submit'])) {
 
    $email = htmlspecialchars($_POST['email']);
    $password = sha1($_POST['password']);
 
    if ((!empty($email)) && (!empty($password))) {
 
        $database = getPDO();
        $requestUser = $database->prepare("SELECT * FROM users WHERE user_email = ? AND user_password = ?");
        $requestUser->execute(array($email, $password));
        $userCount = $requestUser->rowCount();
        if ($userCount == 1) {
           
            $userInfo = $requestUser->fetch();
            $_SESSION['userID'] = $userInfo['user_id'];
            $_SESSION['userPseudo'] = $userInfo['user_pseudo'];
            $_SESSION['userEmail'] = $userInfo['user_email'];
            $_SESSION['userPassword'] = $userInfo['user_password'];
            $_SESSION['userAdmin'] = $userInfo['isadmin'];
            $_SESSION['userBan'] = $userInfo['isban'];
            $_SESSION['userRegisterDate'] = $userInfo['registerdate'];
            $succesMessage = 'Bravo, vous êtes maintenant connecté !';
            header('refresh:3;url=index.php');
 
        } else {
            $errorMessage = 'Email ou mot de passe incorrect!';
        }
    } else {
        $errorMessage = 'Veuillez remplir tous les champs..';
    }
}
 
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Espace Client - Connexion</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="text-center">
            <h3>Espace Client - Connexion</h3>
            <a href="index.php">Accueil</a>
            <a href="register.php">S'inscrire</a>
        </div>
        <div class="form-div text-center">
            <h3>Connexion</h3>
            <?php if (isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p> <?php } ?>
            <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p> <?php } ?>
            <form method="post" action="">
 
                <span>Adresse Email :</span><br>
                <input type="email" name="email" placeholder="Email"><br>
 
                <span>Mot de passe :</span><br>
                <input type="password" name="password" placeholder="Mot de passe"><br><br>
 
                <input type="submit" name="submit" value="Se connecter">
            </form>
        </div>
    </body>
</html>