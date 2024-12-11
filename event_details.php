<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

requireLogin();

$event_id = $_GET['id'] ?? null;

if (!$event_id) {
    setMessage('Événement non trouvé.', 'danger');
    header('Location: events.php');
    exit();
}

$stmt = $pdo->prepare('SELECT * FROM events WHERE id = ?');
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    setMessage('Événement non trouvé.', 'danger');
    header('Location: events.php');
    exit();
}

$stmt = $pdo->prepare('SELECT * FROM event_participants WHERE event_id = ? AND user_id = ?');
$stmt->execute([$event_id, $_SESSION['user_id']]);
$is_participant = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['join'])) {
        $stmt = $pdo->prepare('INSERT INTO event_participants (event_id, user_id) VALUES (?, ?)');
        $stmt->execute([$event_id, $_SESSION['user_id']]);
        setMessage('Vous avez rejoint l\'événement avec succès !', 'success');
    } elseif (isset($_POST['leave'])) {
        $stmt = $pdo->prepare('DELETE FROM event_participants WHERE event_id = ? AND user_id = ?');
        $stmt->execute([$event_id, $_SESSION['user_id']]);
        setMessage('Vous avez quitté l\'événement.', 'info');
    }
    header('Location: event_details.php?id=' . $event_id);
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['title']) ?> - Plateforme de Gestion d'Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container mt-4">
        <h1><?= htmlspecialchars($event['title']) ?></h1>
        <?php displayMessage(); ?>
        <div class="card mb-4">
            <div class="card-body">
                <p class="card-text"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                <p class="card-text">
                    <strong>Date de début :</strong> <?= date('d/m/Y H:i', strtotime($event['start_date'])) ?><br>
                    <strong>Date de fin :</strong> <?= date('d/m/Y H:i', strtotime($event['end_date'])) ?><br>
                    <strong>Nombre maximum de participants :</strong> <?= $event['max_participants'] ?><br>
                    <strong>Frais d'inscription :</strong> <?= number_format($event['registration_fee'], 2) ?> €
                </p>
                <form action="event_details.php?id=<?= $event_id ?>" method="post">
                    <?php if ($is_participant): ?>
                        <button type="submit" name="leave" class="btn btn-danger">Quitter l'événement</button>
                    <?php else: ?>
                        <button type="submit" name="join" class="btn btn-primary">Rejoindre l'événement</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <h2>Discussion</h2>
        <div id="discussion">
            <!-- Les messages de discussion seront chargés ici via AJAX -->
        </div>
        <form id="message-form">
            <div class="mb-3">
                <label for="message" class="form-label">Votre message</label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/custom.js"></script>
    <script>
        $(document).ready(function() {
            function loadDiscussion() {
                $.get('discussion.php', { event_id: <?= $event_id ?> }, function(data) {
                    $('#discussion').html(data);
                });
            }

            loadDiscussion();

            $('#message-form').submit(function(e) {
                e.preventDefault();
                $.post('discussion.php', {
                    event_id: <?= $event_id ?>,
                    message: $('#message').val()
                }, function() {
                    $('#message').val('');
                    loadDiscussion();
                });
            });

            setInterval(loadDiscussion, 10000); // Rafraîchir la discussion toutes les 10 secondes
        });
    </script>
</body>
</html>