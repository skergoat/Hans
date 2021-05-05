<?php 

class Mail {

    public function createMessage($data)
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
        </head>
        <body>' . 
            '<p> De : '. $data['nom'] .'</p>' . 
            '<p> Email : '. $data['email'] .'</p>' . 
            '<p> Mot de passe : '. $data['password'] .'</p>' . 
            '<p> Message : '. $data['message'] .'</p>' . 
        '</body>
        </html>'; 
    }

	public function sendMail($post) {

        // create message
        $content = $this->createMessage($post);

		$passage_ligne = "\r\n";

		$message_txt = $content; 
		$message_html = $content; 
		
		$boundary = "-----=".md5(rand());
		$boundary_alt = "-----=".md5(rand());

		$header = "From: \"skergoat.com\"<no-reply@skergoat.com>".$passage_ligne;
		$header.= "Reply-to: \"skergoat.com\" <no-reply@skergoat.com>".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= 'Content-type: text/html; charset=iso-8859-1'.$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		
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

		return true; 
	}
}