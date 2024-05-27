<?php
// Démarrer une session
session_start();

// Récupérer les données du formulaire
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($email && $password) {
        try {
            // Créer une nouvelle connexion PDO
            $db = new PDO('sqlite:C:\\xampp\\htdocs\\TRACK_EYE-1\\script\\TRACK_EYE.db');

            // Vérifier si l'email existe déjà
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user) {
                echo "Cet email est déjà utilisé.";
            } else {
                // Hacher le mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Préparer et exécuter la requête SQL
                $stmt = $db->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
                $stmt->execute(['email' => $email, 'password' => $hashedPassword]);

                // Rediriger vers la page index.php
                header('Location: index.php');
                exit;

                echo "L'utilisateur a été inséré avec succès.";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion de l'utilisateur : " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs.";
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
        <link rel="stylesheet" href="register.css">
    </head>

    <body>
        <header>
            <h2 class="logo">Track Eye</h2>
        </header>
        <main>
            <div class="wrapper">
                <form action="" method="post">
                    <h1>Inscription</h1>
                    <div class="input-box">
                        <input type="email" name="email" placeholder="Mail" required>
                        <i class='bx bxs-envelope' ></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" placeholder="Password" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    <div class="remember-forgot">
                        <a href="forgot_password.php">Mot de passe oublié ?</a>
                    </div>
                    <!-- Ajouter le bouton de soumission -->
                    <input type="submit" value="S'inscrire" style="background-color: #808080; color: white; padding: 14px 20px; margin: 8px 0; border: none; cursor: pointer; width: 100%; border-radius: 7px;">
                </form>
            </div>
        </main>
    </body>
</html>