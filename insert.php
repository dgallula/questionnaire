<?php
$alert = false;
include_once('pdo.php');

// selection des groupes
$sqlGroupes = 'SELECT * FROM groupes ';
$groupesStatement = $pdo->prepare($sqlGroupes);
$groupesStatement->execute();
$groupes = $groupesStatement->fetchAll();

// selection des questions
$sqlQuestions = 'SELECT * FROM questions q ';
$questionsStatement = $pdo->prepare($sqlQuestions);
$questionsStatement->execute();
$questions = $questionsStatement->fetchAll();

// selection des reponses du questionnaire
$sqlResponses = 'SELECT * FROM questionnaire';
$responsesStatement = $pdo->prepare($sqlResponses);
$responsesStatement->execute();
$responses = $responsesStatement->fetchAll();

// insertion du nouveau groupe
if (isset($_POST["newGroupe"])) {
  $sqlQuery = 'INSERT INTO groupes(grName) VALUES (:grName)';
  $insertQuestionnaire = $pdo->prepare($sqlQuery);

  $insertQuestionnaire->execute([
    'grName' => $_POST["newGroupe"]

  ]);
  $alert = true;
}

// insertion de la nouvelle question
if (isset($_POST["groupe"]) && isset($_POST["newQuestion"])) {
  $sqlQuery = 'INSERT INTO questions(groupeId, question) VALUES (:groupeId , :question)';
  $insertQuestionnaire = $pdo->prepare($sqlQuery);

  $insertQuestionnaire->execute([
    'groupeId' => $_POST["groupe"],
    'question' => $_POST["newQuestion"],

  ]);
  $alert = true;
}
?>
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Questionnaire</title>
</head>

<body>
  <div class="container">
    <h1>Questionnaire</h1>
    <div class="row">
      <?php

      if ($alert) {
        echo "<div class='alert alert-info' role='alert'>information enregistrée.</div>";
      }
      ?>
      <div class="col-6">
        <div class="card">
          <div class="card-body">
            <h6>Nouveau groupe</h6>
            <form method="POST" action="insert.php">
              <div class="mb-3">
                <label for="newGroupe" class="form-label">Groupe</label>
                <input type="text" name="newGroupe" class="form-control" id="groupe" aria-describedby="groupeHelp">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <div>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">NOM DES GROUPES</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($groupes as $groupe) {
                  ?>
                    <tr>
                      <th scope="row"><?php echo $groupe['id']; ?></th>
                      <td><?php echo $groupe['grName']; ?></td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card">
          <div class="card-body">
            <h6>nouvelle question</h6>
            <form method="POST" action="insert.php">
              <div class="mb-3">
                <label for="gr" class="form-label">Groupe</label>
                <select class="form-select" name="groupe" aria-label="Default select example">
                  <option selected>Selectione le bon groupe</option>
                  <?php
                  foreach ($groupes as $groupe) {
                  ?>
                    <option value="<?php echo $groupe['c.id']; ?>"><?php echo $groupe['grName']; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="q" class="form-label">Question</label>
                <input type="text" name="newQuestion" class="form-control" id="q">
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">GROUPE ID</th>
                  <th scope="col">QUESTIONS</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($questions as $question) {
                ?>
                  <tr>
                    <th scope="row"><?php echo $question['id']; ?></th>
                    <td><?php echo $question['groupeId']; ?></td>
                    <td><?php echo $question['question']; ?></td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h6>Resultat questionnaire</h6>
              <table class="table">
              <thead>
                <tr>       
                  <th scope="row">User</th>       
                  <?php
                    foreach ($questions as $question) {
                    ?>
                    <th scope="row"><?php echo $question['question']; ?></th>
                <?php
                }
                ?>
                </tr>
              </thead>
              <tbody>
              <?php
                  foreach ($responses as $response) {
                    $data = json_decode($response['reponses'], true);
                  ?>
                   <tr>   
                      <td><?php echo $response['userid']; ?></td>
                      <?php
                        foreach ($data as $key => $result) {
                        ?> 
                            <td><?php echo $result; ?></td>
                        <?php
                        }
                        ?>
                    </tr>
                  <?php
                  }
                  ?>
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>