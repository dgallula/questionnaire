<?php
try {
  $pdo = new PDO('mysql:host=localhost;dbname=questionnaire;charset=utf8', 'root', '');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}
