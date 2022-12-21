<?php
include_once('pdo.php');

$sqlQuery = 'INSERT INTO questionnaire(userid, reponses ,createdAt) VALUES (:userid, :responses, :createdAt)';

$insertQuestionnaire = $pdo->prepare($sqlQuery);

$insertQuestionnaire->execute([
  'userid' => 1,
  'responses' => json_encode($_POST),
  'createdAt' => date("Y-m-d H:i:s")

]);
?>

<html>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Questionnaire</title>
</head>

<body>
  <div class="container">

    <h1>Questionnaire</h1>
    <div class="card">
      <div class="card-body">
        <div class="alert alert-info" role="alert">
          Merci d'avoir répondu à notre questionnaire.
        </div>
      </div>
    </div>
  </div>
</body>

</html>