<?php 
ob_start(); // Activer la mise en tampon de sortie
include 'db.php'; 
session_start(); // Démarrer la session

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Récupérer les données du formulaire
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($email && $password) {
        try {
            // Créer une nouvelle connexion PDO
            $db = new PDO('sqlite:C:\\xampp\\htdocs\\TRACK_EYE-1\\script\\TRACK_EYE.db');

            // Préparer et exécuter la requête SQL
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            // Vérifier les informations de connexion
            if ($user && password_verify($password, $user['password'])) {
                // Les informations de connexion sont correctes
                $_SESSION['user'] = $user;

                // Rediriger vers la page index.php
                header('Location: index.php');
                exit;
            } else {
                // Les informations de connexion sont incorrectes
                $message = 'Email ou mot de passe incorrect.';
            }
        } catch (PDOException $e) {
            $message = 'Erreur lors de la connexion à la base de données : ' . $e->getMessage();
        }
    } else {
        $message = 'Veuillez remplir tous les champs.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="login.css">
    </head>

    <body>
        <header>
            <h2 class="logo">Track Eye</h2>
        </header>
        <main>
            <div class="wrapper">
                <form action="" method="post">
                    <h1>Login</h1>
                    <div class="input-box">
                        <input type="email" name="email" placeholder="Mail" required>
                        <i class='bx bxs-envelope' ></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" placeholder="Password" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    <!-- Ajouter le bouton de soumission -->
                    <input type="submit" value="Login" style="background-color: #808080; color: white; padding: 14px 20px; margin: 8px 0; border: none; cursor: pointer; width: 100%; border-radius: 7px;">
                    <!-- Afficher le message d'erreur -->
                    <?php if ($message): ?>
                        <p><?php echo $message; ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </main>
    </body>
</html>