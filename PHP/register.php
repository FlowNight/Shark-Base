<?php
 
session_start();
include 'inc/database.php';
 
if (isset($_SESSION['userEmail'])) {
    header('Location:index.php');
}
 
if (isset($_POST['submit'])){
   
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = sha1($_POST['password']);
    $password_confirm = sha1($_POST['password_confirm']);
    date_default_timezone_set('Europe/Paris');
    $date = date('d/m/Y à H:i:s');
 
    if ((!empty($pseudo)) && (!empty($email)) && (!empty($password_confirm)) && (!empty($password))) {
        if (strlen($pseudo) <= 16) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if ($password == $password_confirm) {
 
                    $database = getPDO();
                    $rowEmail = countDatabaseValue($database, 'user_email', $email);
                    if ($rowEmail == 0) {
                        $rowPseudo = countDatabaseValue($database, 'user_pseudo', $pseudo);
                        if ($rowPseudo == 0) {
                            $insertMember = $database->prepare("INSERT INTO users(user_pseudo, user_email, user_password, isadmin, isban, registerdate) VALUES(?, ?, ?, ?, ?, ?)");
                            $insertMember->execute([
                                $pseudo,
                                $email,
                                $password,
                                0,
                                0,
                                $date
                            ]);
                            $succesMessage = "Votre compte à bien été créé !";
                            header('refresh:3;url=login.php');
                        } else {
                            $errorMessage = 'Cette pseudo est déjà utilisée..';
                        }
                    } else {
                        $errorMessage = 'Cette email est déjà utilisée..';
                    }
                } else {
                    $errorMessage = 'Les mots de passes ne correspondent pas...';
                }
            } else {
                $errorMessage = "Votre email n'est pas valide...";
            }
        } else {
            $errorMessage = 'Le pseudo est trop long...';
        }
    } else {
        $errorMessage = 'Veuillez remplir tous les champs...';
    }
}
 
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Espace Client - Inscription</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="text-center">
            <h3>Espace Client - Inscription</h3>
            <a href="index.php">Accueil</a>
            <a href="login.php">Se Connecter</a>
        </div>
        <div class="form-div text-center">
            <h3>Inscription</h3>
            <?php if (isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p> <?php } ?>
            <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p> <?php } ?>
            <form method="post" action="">
 
                <span>Pseudo :</span><br>
                <input type="text" name="pseudo" placeholder="Pseudo" <?php if (isset($pseudo)) { ?>value="<?= $pseudo ?>" <?php } ?>><br>
 
                <span>Adresse Email :</span><br>
                <input type="email" name="email" placeholder="Email" <?php if (isset($email)) { ?>value="<?= $email ?>" <?php } ?>><br>
 
                <span>Mot de passe :</span><br>
                <input type="password" name="password" placeholder="Mot de passe"><br>
 
                <span>Confirmation Mot de passe :</span><br>
                <input type="password" name="password_confirm" placeholder="Confirmation Mot de passe"><br><br>
 
                <input type="submit" name="submit" value="S'inscrire">
            </form>
        </div>
    </body>
</html>