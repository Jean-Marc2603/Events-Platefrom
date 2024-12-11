<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

requireLogin();

$stmt = $pdo->query('SELECT * FROM events ORDER BY start_date');
$events = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements - Plateforme de Gestion d'Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container mt-4">
        <h1>Liste des événements</h1>
        <?php displayMessage(); ?>
        <div class="row">
            <?php foreach ($events as $event): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr($event['description'], 0, 100)) ?>...</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Du <?= date('d/m/Y H:i', strtotime($event['start_date'])) ?>
                                    au <?= date('d/m/Y H:i', strtotime($event['end_date'])) ?>
                                </small>
                            </p>
                            <a href="event_details.php?id=<?= $event['id'] ?>" class="btn btn-primary">Voir les détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>