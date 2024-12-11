<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

requireLogin();

$event_id = $_GET['event_id'] ?? $_POST['event_id'] ?? null;

if (!$event_id) {
    echo "Erreur : ID de l'événement manquant.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare('INSERT INTO discussions (event_id, user_id, message) VALUES (?, ?, ?)');
    $stmt->execute([$event_id, $user_id, $message]);

    exit();
}

$stmt = $pdo->prepare('SELECT d.*, u.username FROM discussions d JOIN users u ON d.user_id = u.id WHERE d.event_id = ? ORDER BY d.created_at DESC LIMIT 50');
$stmt->execute([$event_id]);
$messages = $stmt->fetchAll();

foreach ($messages as $message):
?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($message['username']) ?></h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($message['message'])) ?></p>
            <p class="card-text"><small class="text-muted"><?= date('d/m/Y H:i', strtotime($message['created_at'])) ?></small></p>
        </div>
    </div>
<?php
endforeach;
?>