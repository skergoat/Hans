<?php

    require "vendor/validator.php";
    require "vendor/recaptcha.php";
    
    // if form is sent 
    if(!empty($_POST)) {

        $recaptcha = new Recaptcha($_POST);
        $validator = new Validator($_POST);
        
        // check recaptcha
        if($recaptcha->checkRecaptcha())
        {
            // validate form 
            if($validator->isValid()) {
                // send mail
                $validator->send();
            }
        }
        else 
        {
            // recaptcha error
            $validator->setSuccessMessage("recaptcha");
        }        
    }
?>
<!doctype html>
<html lang="fr">
<head>
    <!-- meta, title -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mon Formulaire</title>
    <!-- styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <!-- Recaptcha -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LdAC8caAAAAAGmCIVRFLYZaF9BWqVcpV8pWs5Uk"></script>
</head>
<body>

    <div class="container">
        <!-- title  -->
        <div class="jumbotron">
            <h1>Mon Formulaire</h1>
        </div>
        <!-- alert -->
        <?php if(!empty($validator)) {
                // form success or error  
                if(!empty($validator->getSuccessMessage())) {
                    if($validator->getSuccessMessage() == "success") { ?> 
                        <div class="alert alert-success" role="alert">
                            Message envoyé !
                        </div>
        <?php      } else if ($validator->getSuccessMessage() == "recaptcha") { ?>
                        <div class="alert alert-danger" role="alert">
                            Recaptcha Invalide
                        </div>
        <?php       } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Une erreur s'est produite pendant l'envoi du formulaire
                        </div>
        <?php       } 
                }
                else if(!empty($validator->getErrorMessage())) { ?>
                    <div class="alert alert-danger" role="alert">
                        <ul>
                       <?php    
                            foreach($validator->getErrorMessage() as $errorMessage)
                            { ?>
                            <li><?= $errorMessage ?></li>
                            <?php } 
                        ?>
                        </ul>
                    </div>
        <?php  } } ?>
        <!-- form -->
        <form id="sendCaptcha" method="post" action="" >
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
            <!-- <div class="mb-3">
                <label for="inputPassword" class="form-label">Mot de passe</label>
                <input type="password" class="form-control <?php if(!empty($validator)) { if(in_array("password", $validator->getEmptyMessage())) { ?> is-invalid <?php }} ?>" id="inputpassword" name="password">
                <div id="validationServer04Feedback" class="invalid-feedback"><?php if(!empty($validator)) { if(in_array("password", $validator->getEmptyMessage()))  { echo $validator->getEmptyErrorMessage(); }} ?></div>
            </div> -->
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
        $('#sendCaptcha').submit(function(event) {
            // we stoped it
            event.preventDefault();

            var nom = $('#inputnom').val();
            var email = $("#inputmail").val();
            // var password = $("#inputpassword").val();
            var message = $("#inputmessage").val();

            grecaptcha.ready(function() {
                grecaptcha.execute('6LdAC8caAAAAAGmCIVRFLYZaF9BWqVcpV8pWs5Uk', {action: 'send_mail'}).then(function(token) {

                    $('#sendCaptcha').prepend('<input type="hidden" name="token" value="' + token + '">');
                    $('#sendCaptcha').prepend('<input type="hidden" name="action" value="send_mail">');

                    setTimeout(function() {

                        $('#sendCaptcha').unbind('submit').submit();

                    }, 500); 

                });;
            });
        })
    </script>
</body>
</html>
