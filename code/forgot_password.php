<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? null;
    $newPassword = $_POST['newPassword'] ?? null;

    if ($email && $newPassword) {
        try {
            $db = new PDO('sqlite:C:\\xampp\\htdocs\\TRACK_EYE-1\\script\\TRACK_EYE.db');

            // Hacher le nouveau mot de passe
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Préparer et exécuter la requête SQL
            $stmt = $db->prepare("UPDATE users SET password = :password WHERE email = :email");
            $stmt->execute(['email' => $email, 'password' => $hashedPassword]);

    // Ajouter le message de succès
    $message = 'Mot de passe modifié avec succès';

        } catch (PDOException $e) {
            $message = 'Erreur lors de la modification du mot de passe : ' . $e->getMessage();
        }
    } else {
        $message = 'Veuillez remplir tous les champs.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
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
                    <h1>Modifier le mot de passe</h1>
                    <div class="input-box">
                        <input type="email" name="email" placeholder="Mail" required>
                        <i class='bx bxs-envelope' ></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="newPassword" placeholder="Nouveau mot de passe" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    <!-- Ajouter le bouton de soumission -->
                    <input type="submit" value="Modifier le mot de passe" style="background-color: #808080; color: white; padding: 14px 20px; margin: 8px 0; border: none; cursor: pointer; width: 100%; border-radius: 7px;">
                    <?php if ($message): ?>
    <p class="text-center"><?php echo $message; ?></p>
<?php endif; ?>
                </form>
               
            </div>
        </main>
    </body>
</html>