<?php
 
session_start();
include 'includes/database.php';
 
if (isset($_POST['submit'])) {
 
    $oldPassword = sha1($_POST['old_password']);
    $newPassword = sha1($_POST['password']);
    $confirmNewPassword = sha1($_POST['confirm_password']);
 
    if ($_SESSION['userPassword'] == $oldPassword) {
        if ($newPassword == $confirmNewPassword) {
           
            $database = getPDO();
            $request = $database->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
            $request->execute([
                $newPassword,
                $_SESSION['userEmail']
            ]);
            $succesMessage = 'Le mot de passe est maintenant modifié !';
            header('refresh:3;url=index.php');
 
        } else {
            $errorMessage = 'Les mots de passes ne sont pas identiques!';
        }
    } else {
        $errorMessage = 'Le mot de passe est incorrect..';
    }
}
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title> Accueil </title>
        <link rel="stylesheet" type="text/css" href="style-register.css">
    </head>
    <body>
        <div class="text-center">
            <h3> Accueil </h3>
            <a href="login.php"> Se connecter </a><br>
            <a href="register.php"> S'inscrire </a>
        </div>
        <div class="form-div text-center">
                <h3>Information</h3>
                <?php if (isset($_SESSION['userEmail'])) { ?>
                    <?php if(($_SESSION['userBan'] != null) && ($_SESSION['userBan'] == 1)) {?>
                        <p style="color: red;"><b>VOUS ETES BANNI</b></p>
                    <?php } else { ?>
                        <p>Bonjour, <?= $_SESSION['userPseudo'] ?> !</p>
                        <p>Email : <?= $_SESSION['userEmail'] ?></p>
                        <p>Inscrit le <?= $_SESSION['userRegisterDate'] ?></p>
                        <a href="logout.php"> Se Déconnecter</a>
                        <br>
                        <h3>Changer de mot de passe</h3>
                        <?php if (isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p> <?php } ?>
                        <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p> <?php } ?>
                        <form method="post" action="">
 
                            <span>Ancien Mot de passe :</span><br>
                            <input type="password" name="old_password" placeholder="Ancien Mot de passe"><br>
 
                            <span>Nouveau Mot de passe :</span><br>
                            <input type="password" name="password" placeholder="Nouveau Mot de passe"><br><br>
 
                            <span>Confirmation du Nouveau Mot de passe :</span><br>
                            <input type="password" name="confirm_password" placeholder="Confirmation Mot de passe"><br><br>
 
                            <input type="submit" name="submit" value="Valider">
                        </form>
                       
                    <?php } } else { ?>
                    <p> Vous n'êtes pas connecté ! </p>
                <?php } ?>
        </div>
    </body>
</html>