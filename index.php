<?php

    // require "vendor/mailer.php";

    if(!empty($_POST)) {

        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $content = $_POST['message'];

        // $mail = new Mail($nom, $email, $password, $content);

        $passage_ligne = "\r\n";

		$message_txt = $content; 
		$message_html = '<!DOCTYPE html><html><head></head><body>' . $content . '</body></html>'; 
		
		$boundary = "-----=".md5(rand());
		$boundary_alt = "-----=".md5(rand());

		$header = "From: \"skergoat.com\"<no-reply@skergoat.com>".$passage_ligne;
		$header.= "Reply-to: \"skergoat.com\" <no-reply@skergoat.com>".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		$message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
		$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;

		$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_txt.$passage_ligne;
		 
		$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
		 
		$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_html.$passage_ligne;

		$message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
		 
		$message.= $passage_ligne."--".$boundary.$passage_ligne;
		
		mail("skergoatweb@gmail.com", "test", $content, $header);

		echo "SENT !"; 

        print_r($_POST);
    }
    else {
        print_r("PAS POST");
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
                <label for="exampleInputPassword1" class="form-label">Nom</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="nom">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
               <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Message</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message"></textarea>
            </div>
            <!-- <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>
</html>
