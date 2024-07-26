<?php

require_once 'login/config.php';

$query = isset($_GET['query']) ?? '';

if (!empty($query)) {
    // Suche nach Produkten
    $pdo=dbcon();
    $sql = "SELECT * FROM produkte WHERE name LIKE :query OR beschreibung LIKE :query";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':query' => "%$query%"]);
    $produkte = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Suche nach Lieferanten
    $sql = "SELECT * FROM lieferanten WHERE name LIKE :query OR beschreibung LIKE :query";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':query' => "%$query%"]);
    $lieferanten = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Suchergebnisse</title>
</head>
<body>
<h1>Suchergebnisse für "<?php echo htmlspecialchars($query); ?>"</h1>

<?php if (!empty($produkte)): ?>
    <h2>Produkte</h2>
    <ul>
        <?php foreach ($produkte as $produkt): ?>
            <li><?php echo htmlspecialchars($produkt['name']); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($lieferanten)): ?>
    <h2>Lieferanten</h2>
    <ul>
        <?php foreach ($lieferanten as $lieferant): ?>
            <li><?php echo htmlspecialchars($lieferant['name']); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<a href="/templates/admin/search.php">Zurück zur Suche</a>
</body>
</html>