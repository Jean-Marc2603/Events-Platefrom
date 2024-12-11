<?php
require_once 'includes/functions.php';

session_destroy();
setMessage('Vous avez été déconnecté avec succès.', 'info');
header('Location: index.php');
exit();