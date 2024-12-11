<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $max_participants = $_POST['max_participants'];
    $registration_fee = $_POST['registration_fee'];
    $creator_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare('INSERT INTO events (title, description, start_date, end_date, max_participants, registration_fee, creator_id) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$title, $description, $start_date, $end_date, $max_participants, $registration_fee, $creator_id]);

    setMessage('Événement créé avec succès !', 'success');
    header('Location: events.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un événement - Plateforme de Gestion d'Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container mt-4">
        <h1>Créer un événement</h1>
        <?php displayMessage(); ?>
        <form action="create_event.php" method="post" id="event-form">
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Date de début</label>
                <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">Date de fin</label>
                <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="mb-3">
                <label for="max_participants" class="form-label">Nombre maximum de participants</label>
                <input type="number" class="form-control" id="max_participants" name="max_participants" required>
            </div>
            <div class="mb-3">
                <label for="registration_fee" class="form-label">Frais d'inscription</label>
                <input type="number" step="0.01" class="form-control" id="registration_fee" name="registration_fee" required>
            </div>
            <button type="submit" class="btn btn-primary">Créer l'événement</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>