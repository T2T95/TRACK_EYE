<?php
include 'db.php';

function handlePostRequestAntenne() {
    global $db;
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            $stmt = $db->prepare("INSERT INTO ANTENNE (ID_ANTENNE, EMPLACEMENT) VALUES (?, ?)");
            $stmt->execute([$_POST['id_antenne'], $_POST['emplacement']]);
        } elseif ($_POST['action'] == 'delete') {
            $stmt = $db->prepare("DELETE FROM ANTENNE WHERE ID = ?");
            $stmt->execute([$_POST['id']]);
        } elseif ($_POST['action'] == 'edit') {
            $stmt = $db->prepare("UPDATE ANTENNE SET ID_ANTENNE = ?, EMPLACEMENT = ? WHERE ID = ?");
            $stmt->execute([$_POST['id_antenne'], $_POST['emplacement'], $_POST['id']]);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    handlePostRequestAntenne();
}

$antennes = $db->query("SELECT * FROM ANTENNE");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Track Eye - Gérer les Antennes</title>
    <link rel="stylesheet" href="manage_antenne.css">
    <script src="scripts.js"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
	<header>
		<img src="image2.jpg" alt="Track Eye System Banner" class="img-fluid">
		<h1>Gestion des Antennes</h1>
	<div class="mb-3 text-end">
		<a href="index.php" class="btn btn-secondary">Accueil</a>
		<a href="manage_etiq_pc.php" class="btn btn-secondary">Gérer le matériel</a>
	</div>

	</header>

    <form action="manage_antenne.php" method="post" onsubmit="return confirm('Êtes-vous sûr?');">
        <input type="hidden" name="action" value="add">
        <div class="mb-3">
            <label for="id_antenne" class="form-label">Numéro d'antenne</label>
            <input type="text" id="id_antenne" name="id_antenne" required class="form-control">
        </div>
        <div class="mb-3">
            <label for="emplacement" class="form-label">Emplacement</label>
            <input type="text" id="emplacement" name="emplacement" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <table class="table">
        <thead>
        <tr>
    <th>ID</th>
    <th>Numéro d'Antenne</th>
<th>Emplacement</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($antennes as $antenne) { ?>
    <tr>
        <td><?php echo htmlspecialchars($antenne['ID']); ?></td>
        <td><?php echo htmlspecialchars($antenne['ID_ANTENNE']); ?></td>
        <td><?php echo htmlspecialchars($antenne['EMPLACEMENT']); ?></td>
        <td>
        <button onclick="var form = document.getElementById('editForm<?php echo $antenne['ID']; ?>'); form.style.display = form.style.display === 'block' ? 'none' : 'block';" class="btn btn-primary" style="margin-right: 10px;">Modifier</button>
        <form id="editForm<?php echo $antenne['ID']; ?>" style="display: none;" action="manage_antenne.php" method="post">
            <input type="hidden" name="id" value="<?php echo $antenne['ID']; ?>">
            <input type="hidden" name="action" value="edit">
            <label for="edit_id_antenne<?php echo $antenne['ID']; ?>">Numéro d'Antenne:</label><br>
            <input type="text" id="edit_id_antenne<?php echo $antenne['ID']; ?>" name="id_antenne" value="<?php echo $antenne['ID_ANTENNE']; ?>"><br>
            <label for="edit_emplacement<?php echo $antenne['ID']; ?>">Emplacement:</label><br>
            <input type="text" id="edit_emplacement<?php echo $antenne['ID']; ?>" name="emplacement" value="<?php echo $antenne['EMPLACEMENT']; ?>"><br>
            <button type="submit" class="btn btn-success" style="margin-top: 10px; margin-bottom: 10px; margin-right: 10px;">Enregistrer</button>
        </form>
        <form action="manage_antenne.php" method="post" style="display: inline;">
            <input type="hidden" name="id" value="<?php echo $antenne['ID']; ?>">
            <input type="hidden" name="action" value="delete">
            <button type="submit" class="btn btn-danger" >Supprimer</button>
        </form>
        </td>
    </tr>
    <?php } ?>
</tbody>