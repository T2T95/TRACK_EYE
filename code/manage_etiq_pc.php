<?php
include 'db.php';

function handlePostRequest() {
    global $db;
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            $date_fin = isset($_POST['date_fin']) ? $_POST['date_fin'] : '2099-01-01';
            $stmt = $db->prepare("INSERT INTO ETIQ_PC (NUM_ETIQ, NUM_PC, DATE_DEBUT, DATE_FIN) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_POST['num_etiq'], $_POST['num_pc'], $_POST['date_debut'], $date_fin]);
        } elseif ($_POST['action'] == 'edit') {
            $stmt = $db->prepare("UPDATE ETIQ_PC SET NUM_ETIQ = ?, NUM_PC = ?, DATE_DEBUT = ?, DATE_FIN = ? WHERE ID = ?");
            $num_etiq = isset($_POST['num_etiq']) ? $_POST['num_etiq'] : '';
            $num_pc = isset($_POST['num_pc']) ? $_POST['num_pc'] : '';
            $date_debut = isset($_POST['date_debut']) ? $_POST['date_debut'] : '';
            $date_fin = isset($_POST['date_fin']) ? $_POST['date_fin'] : '2099-01-01';
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            
            $stmt->execute([$num_etiq, $num_pc, $date_debut, $date_fin, $id]);
        } elseif ($_POST['action'] == 'delete') {
            $stmt = $db->prepare("DELETE FROM ETIQ_PC WHERE ID = ?");
            $stmt->execute([$_POST['id']]);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    handlePostRequest();
}
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $date_fin = isset($_POST['neverExpires']) ? '2099-01-01' : $_POST['date_fin'];
    
    // Vérifiez si une ligne avec le même num_etiq et num_pc existe déjà
    $stmt = $db->prepare("SELECT * FROM ETIQ_PC WHERE NUM_ETIQ = ? AND NUM_PC = ?");
    $stmt->execute([$_POST['num_etiq'], $_POST['num_pc']]);
    $row = $stmt->fetch();

    if ($row) {
        // Si une telle ligne existe déjà, mettez à jour cette ligne
        $stmt = $db->prepare("UPDATE ETIQ_PC SET DATE_DEBUT = ?, DATE_FIN = ? WHERE NUM_ETIQ = ? AND NUM_PC = ?");
        $stmt->execute([$_POST['date_debut'], $date_fin, $_POST['num_etiq'], $_POST['num_pc']]);
    } else {
        // Sinon, insérez une nouvelle ligne
        $stmt = $db->prepare("INSERT INTO ETIQ_PC (NUM_ETIQ, NUM_PC, DATE_DEBUT, DATE_FIN) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['num_etiq'], $_POST['num_pc'], $_POST['date_debut'], $date_fin]);
    }
}

$etiqs = $db->query("SELECT * FROM ETIQ_PC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Track Eye - Gérer le matériel</title>
    <link rel="stylesheet" href="manage_etiq_pc.css">
    <script src="scripts.js"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
	<header>
		<img src="image2.jpg" alt="Track Eye System Banner" class="img-fluid">
		<h1>Gestion RFID & PC</h1>
		<div class="mb-3 text-end">
			<a href="index.php" class="btn btn-secondary">Accueil</a>
			<a href="manage_antenne.php" class="btn btn-secondary">Gérer les antennes</a>
		</div>
    </header>
    <form action="manage_etiq_pc.php" method="post" onsubmit="return confirm('Êtes-vous sûr?');">
        <input type="hidden" name="action" value="add">
        <div class="mb-3">
            <label for="num_etiq" class="form-label">Numéro RFID</label>
            <input type="text" id="num_etiq" name="num_etiq" required class="form-control">
        </div>
        <div class="mb-3">
            <label for="num_pc" class="form-label">Numéro PC</label>
            <input type="text" id="num_pc" name="num_pc" required class="form-control">
        </div>
        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de début</label>
            <input type="date" id="date_debut" name="date_debut" required class="form-control">
        </div>
        <div class="mb-3">
    <label for="date_fin" class="form-label">Date de fin</label>
    <input type="date" id="date_fin" name="date_fin" required class="form-control">
</div>
<!-- Ajout de la case à cocher "N'expire jamais" -->
<div class="mb-3">
    <input type="checkbox" id="neverExpires" name="neverExpires" value="neverExpires">
    <label for="neverExpires">N'expire jamais</label><br>
</div>
<button type="submit" class="btn btn-primary">Ajouter</button>
</form>

<script>
document.getElementById('neverExpires').addEventListener('change', function() {
    var dateFinInput = document.getElementById('date_fin');
    dateFinInput.required = !this.checked;
    dateFinInput.disabled = this.checked;
    if (this.checked) {
        dateFinInput.value = '2099-01-01';
    } else {
        dateFinInput.value = '';
    }
});
</script>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Numéro RFID</th>
                <th>Numéro PC</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etiqs as $etiq) { ?>
                <tr>
    <td><?php echo htmlspecialchars($etiq['ID']); ?></td>
    <td><?php echo htmlspecialchars($etiq['NUM_ETIQ']); ?></td>
    <td><?php echo htmlspecialchars($etiq['NUM_PC']); ?></td>
    <td><?php echo htmlspecialchars($etiq['DATE_DEBUT']); ?></td>
<td><?php echo $etiq['DATE_FIN'] ? htmlspecialchars($etiq['DATE_FIN']) : '2099-01-01'; ?></td>
<td>
<button onclick="toggleForm('editForm<?php echo $etiq['ID']; ?>')" class="btn btn-primary" style="margin-right: 10px;">Modifier</button>

<script>
function toggleForm(formId) {
    var form = document.getElementById(formId);
    if (form.style.display === "none" || form.style.display === "") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}
</script><form id="editForm<?php echo $etiq['ID']; ?>" style="display: none;" action="manage_etiq_pc.php" method="post">
    <input type="hidden" name="id" value="<?php echo $etiq['ID']; ?>">
    <input type="hidden" name="action" value="edit">
    <label for="num_etiq">Numéro RFID:</label><br>
    <input type="text" id="num_etiq" name="num_etiq" value="<?php echo $etiq['NUM_ETIQ']; ?>"><br>
    <?php
    if (isset($_POST['num_etiq'])) {
        $num_etiq = $_POST['num_etiq'];
    } else {
        $num_etiq = '';
    }
    ?>
    <label for="num_pc">Numéro PC:</label><br>
    <input type="text" id="num_pc" name="num_pc" value="<?php echo $etiq['NUM_PC']; ?>"><br>
    <label for="date_debut">Date de début:</label><br>
    <input type="date" id="date_debut" name="date_debut" value="<?php echo $etiq['DATE_DEBUT']; ?>"><br>
    <label for="date_fin">Date de fin:</label><br>
    <input type="date" id="date_fin<?php echo $etiq['ID']; ?>" name="date_fin" value="<?php echo $etiq['DATE_FIN']; ?>"><br>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="edit_neverExpires<?php echo $etiq['ID']; ?>" onchange="handleEditNeverExpiresChange(<?php echo $etiq['ID']; ?>)">
        <label class="form-check-label" for="edit_neverExpires<?php echo $etiq['ID']; ?>">N'expire jamais</label>
    </div>
    <button type="submit" class="btn btn-success" style="margin-top: 10px; margin-bottom: 10px; margin-right: 10px;">Enregistrer</button>
</form>

<script>
function handleEditNeverExpiresChange(id) {
    var dateFinInput = document.getElementById('date_fin' + id);
    var neverExpiresCheckbox = document.getElementById('edit_neverExpires' + id);
    if (neverExpiresCheckbox.checked) {
        dateFinInput.value = '2099-01-01';
    } else {
        dateFinInput.value = '';
    }
}
</script>

        <form action="manage_etiq_pc.php" method="post" style="display: inline;">
            <input type="hidden" name="id" value="<?php echo $etiq['ID']; ?>">
            <input type="hidden" name="action" value="delete">
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </td>
</tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
