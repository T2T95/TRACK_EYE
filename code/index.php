<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Track Eye - Accueil</title>
    <link rel="stylesheet" href="index.css">
    <script src="scripts.js"></script>
    <!-- Inclusion de Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <header>
        <img src="image2.jpg" alt="Track Eye System Banner" class="img-fluid">
        <h1>Système de Suivi RFID</h1>
            <div class="mb-3 text-end">
            <a href="register.php" class="btn btn-secondary">Compte Administrateur</a>
                <a href="manage_etiq_pc.php" class="btn btn-secondary">Gérer le matériel</a>
                <a href="manage_antenne.php" class="btn btn-secondary">Gérer les antennes</a>
            </div>

    </header>

    <form action="index.php" method="GET">
        <div class="mb-3">
        <label for="date" class="form-label">Date</label>
<input type="date" id="date" name="date" class="form-control" value="<?php echo isset($_GET['date']) ? htmlspecialchars($_GET['date']) : date('Y-m-d'); ?>">
        </div>
        <div class="mb-3">
    <label for="material" class="form-label">Matériel</label>
    <select id="material" name="material" class="form-select">
        <option value="">Choisir</option>
        <?php
        $stmt = $db->query("SELECT NUM_ETIQ, NUM_PC FROM ETIQ_PC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = (isset($_GET['material']) && $_GET['material'] == $row['NUM_ETIQ']) ? 'selected' : '';
            echo "<option value='" . $row['NUM_ETIQ'] . "' $selected>" . $row['NUM_PC'] . "</option>";
        }
        ?>
    </select>
</div>
<div class="mb-3">
    <label for="antenne" class="form-label">Antenne</label>
    <select id="antenne" name="antenne" class="form-select">
        <option value="">Choisir</option>
        <?php
        $stmt = $db->query("SELECT ID_ANTENNE, EMPLACEMENT FROM ANTENNE");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = (isset($_GET['antenne']) && $_GET['antenne'] == $row['ID_ANTENNE']) ? 'selected' : '';
            echo "<option value='" . $row['ID_ANTENNE'] . "' $selected>" . $row['EMPLACEMENT'] . "</option>";
        }
        ?>
    </select>
</div>
        <button type="submit" class="btn btn-primary">Chercher</button>
    </form>
    <!-- Tableau des résultats -->
    <table class="table">
        <thead>
            <tr>
                <th>Date de détection</th>
                <th>ID RFID</th>
                <th>Matériel</th>
                <th>Antenne</th>
                </tr>
        </thead>
</tr>
</thead>
<tbody>
    <?php
    $conditions = [];
    $params = [];
    if (!empty($_GET['date'])) {
        $conditions[] = "DATE(t.DATE_TIME) = :date";
        $params[':date'] = $_GET['date'];
    }
    if (!empty($_GET['material'])) {
        $conditions[] = "p.NUM_ETIQ = :material";
        $params[':material'] = $_GET['material'];
    }
    if (!empty($_GET['antenne'])) {
        $conditions[] = "a.ID_ANTENNE = :antenne";
        $params[':antenne'] = $_GET['antenne'];
    }
    if (!empty($conditions)) {
        $query = "SELECT t.DATE_TIME, p.NUM_ETIQ, p.NUM_PC, a.EMPLACEMENT FROM TRACK_ETIQ t
                  LEFT JOIN ETIQ_PC p ON t.NUM_ETIQ = p.NUM_ETIQ
                  LEFT JOIN ANTENNE a ON t.ID_ANTENNE = a.ID_ANTENNE "
                  . " WHERE " . implode(' AND ', $conditions);
        $stmt = $db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $row) {
            echo "<tr><td>" . htmlspecialchars($row['DATE_TIME']) . "</td><td>" . htmlspecialchars($row['NUM_ETIQ']) . "</td><td>" . htmlspecialchars($row['NUM_PC']) . "</td><td>" . htmlspecialchars($row['EMPLACEMENT']) . "</td></tr>";
        }
    }
    ?>
</tbody>
    </table>
</div>
</body>
</html>
