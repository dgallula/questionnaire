<?php

include_once('pdo.php');
$id = array();
// selection des questions
$sqlGroupes = 'SELECT *
  FROM groupes g';

$sqlQuestions = 'SELECT *
FROM questions q';

$groupesStatement = $pdo->prepare($sqlGroupes);
$groupesStatement->execute();
$groupes = $groupesStatement->fetchAll();
$g = json_encode($groupes);

$questionsStatement = $pdo->prepare($sqlQuestions);
$questionsStatement->execute();
$questions = $questionsStatement->fetchAll();
$q = json_encode($questions);
?>


<html>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
  <link href="assets/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
  <link href="assets/themes/krajee-fas/theme.css" media="all" rel="stylesheet" type="text/css" />
  <link href="assets/themes/krajee-svg/theme.css" media="all" rel="stylesheet" type="text/css" />

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/js/star-rating.js" type="text/javascript"></script>
  <script src="assets/themes/krajee-fas/theme.js" type="text/javascript"></script>
  <script src="assets/themes/krajee-svg/theme.js" type="text/javascript"></script>
  <title>Questionnaire</title>
</head>

<body>
  <div class="container">
    <h1>Questionnaire</h1>

    <div class="card">
      <div class="card-body">
        <form method="post" action="submit_form.php">
          <?php
         
          foreach ($groupes as $groupe) {
          ?>
            <h6><?php echo $groupe["id"] ." ". $groupe["grName"]; ?></h6>
            <?php
              foreach ($questions as $question) {
                if($groupe["id"] == $question["groupeId"]) {
                  
                  $id["q".$question['id']] = $question['id'];
              ?>
                  <label for="q<?php echo $question['id']; ?>" class="control-label"><?php echo $question['question']; ?></label>
                  <input id="q<?php echo $question['id']; ?>" name="q<?php echo $question['id']; ?>" class=" rating" data-theme="krajee-fas" data-min=0 data-max=4 data-step=0.5 data-size="xs" title="" />
              <?php
            }
          }
          ?>
          <br /> 
          <?php
          }
          ?>
          <div class="form-group" style="margin-top:10px">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>

<script>
  $(document).ready(function() {
    console.log(<?php count($id); ?>)
    for (let i = 0; i <  <?php count($id); ?>; i++) {
      $($id[i]).rating({});
    }

  });
</script>