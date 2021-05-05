<?php

    require "vendor/validator.php";

    if(!empty($_POST)) {
        // validate and send  
        $validator = new Validator($_POST);
        $validator->isValid();
        
        if($validator->isValid()) {
            $validator->send();
        }
    }
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

    <div class="container">
        
        <div class="jumbotron">
            <h1>Mon Formulaire</h1>
        </div>
        <form method="post" action="">
            <div class="mb-3">
                <label for="inputNom" class="form-label">Nom</label>
                <input type="text" class="form-control <?php if(!empty($validator)) { if(in_array("nom", $validator->getEmptyMessage())) { ?> is-invalid <?php }} ?>" id="inputnom" name="nom">
                <div id="validationServer04Feedback" class="invalid-feedback"><?php if(!empty($validator)) { if(in_array("nom", $validator->getEmptyMessage()))  { echo $validator->getEmptyErrorMessage(); }} ?></div>
            </div>
            <div class="mb-3">
                <label for="inputMail" class="form-label">Email</label>
                <input type="email" class="form-control <?php if(!empty($validator)) { if(in_array("email", $validator->getEmptyMessage())) { ?> is-invalid <?php }} ?>" id="inputmail" aria-describedby="emailHelp" name="email">
                <div id="validationServer04Feedback" class="invalid-feedback"><?php if(!empty($validator)) { if(in_array("email", $validator->getEmptyMessage()))  { echo $validator->getEmptyErrorMessage(); }} ?></div>
            </div>
            <div class="mb-3">
                <label for="inputPassword" class="form-label">Mot de passe</label>
                <input type="password" class="form-control <?php if(!empty($validator)) { if(in_array("password", $validator->getEmptyMessage())) { ?> is-invalid <?php }} ?>" id="inputpassword" name="password">
                <div id="validationServer04Feedback" class="invalid-feedback"><?php if(!empty($validator)) { if(in_array("password", $validator->getEmptyMessage()))  { echo $validator->getEmptyErrorMessage(); }} ?></div>
            </div>
            <div class="form-group">
                <label for="inputMessage">Message</label>
                <textarea class="form-control <?php if(!empty($validator)) { if(in_array("message", $validator->getEmptyMessage())) { ?> is-invalid <?php }} ?>" id="inputmessage" rows="3" name="message"></textarea>
                <div id="validationServer04Feedback" class="invalid-feedback"><?php if(!empty($validator)) { if(in_array("message", $validator->getEmptyMessage()))  { echo $validator->getEmptyErrorMessage(); }} ?></div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>
</html>
