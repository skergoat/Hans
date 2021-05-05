<?php

    require "vendor/validator.php";
    // if form is sent 
    if(!empty($_POST)) {
        $validator = new Validator($_POST);
        $validator->isValid();
        // validate and send mail
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
    <script src="https://www.google.com/recaptcha/api.js?render=6Lff8cYaAAAAAPoZTzuSUYTzwxjHDZi3FqOK2W1v"></script>
</head>
<body>

    <div class="container">
        <!-- title  -->
        <div class="jumbotron">
            <h1>Mon Formulaire</h1>
        </div>
        <!-- alert -->
        <?php if(!empty($validator)) { 
                if(!empty($validator->getSuccessMessage())) {
                    if($validator->getSuccessMessage() == "success") { ?> 
                        <div class="alert alert-success" role="alert">
                            Message envoyé !
                        </div>
        <?php       } else if ($validator->getSuccessMessage() == "recaptcha") { ?>
                        <div class="alert alert-danger" role="alert">
                            Recaptcha Invalide
                        </div>
        <?php            } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Une erreur s'est produite pendant l'envoi du formulaire
                        </div>
        <?php }}} ?>
        <!-- form -->
        <form method="post" action="" id="form-test">
            <div class="mb-3">
                <label for="inputNom" class="form-label">Nom</label>
                <!-- error message on each field -->
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
    <!-- script recaptcha -->
    <script>
        $('#form-test').submit(function(event) {
            event.preventDefault();
            var nom = $('#inputnom').val();
            var email = $("#inputmail").val();
            var password = $("#inputpassword").val();
            var message = $("#inputmessage").val();
    
            grecaptcha.ready(function() {
                grecaptcha.execute('6Lff8cYaAAAAAPoZTzuSUYTzwxjHDZi3FqOK2W1v', {action: 'send_mail'}).then(function(token) {
                    $('#form-test').prepend('<input type="hidden" name="token" value="' + token + '">');
                    $('##form-test').prepend('<input type="hidden" name="action" value="subscribe_newsletter">');
                    $('#form-test').unbind('submit').submit();
                });;
            });
        });
    </script>
</body>
</html>
