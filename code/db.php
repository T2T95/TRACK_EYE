<?php

$databasePath = 'C:\xampp\htdocs\TRACK_EYE-1\script\TRACK_EYE.db';
try {
    $db = new PDO('sqlite:' . $databasePath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Unable to connect: " . $e->getMessage() . "<br/>";
    die();
}
?>
