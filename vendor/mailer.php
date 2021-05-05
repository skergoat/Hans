<?php 

// namespace CRFram;

class Mail {

	public function __construct($nom, $email, $password, $message) {
		$this->send($nom, $email, $password, $message);
        print_r("OCFRAM");
	}

	public function send($nom, $email, $password, $message) {

		$passage_ligne = "\r\n";

		$message_txt = $message; 
		$message_html = '<!DOCTYPE html><html><head></head><body>' . $message . '</body></html>'; 
		
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
		
		mail("skergoatweb@gmail.com", $nom, $email, $password, $message, $header);

		echo "SENT !"; 

	}

}