<h2>payment_url <?php echo $paymentdata; ?></h2>
<h2>payment_url <?php echo $email; ?></h2>


<?PHP


	 	$config = Array('mailtype' => 'html');
		$this -> load -> library('email', $config);

		


		$this -> email -> from('support@autovista.in', 'Website');
		$this -> email -> to('saniya.chat360@gmail.com');
		$this -> email -> subject('Message from ' . $email . ' via autovista.in');
		$body = $this -> load -> view('add_payment_booking_view.php', $paymentdata, TRUE);
		$this -> email -> message($body);
		$this -> email -> send();

		$this -> email -> from('support@autovista.in', 'Admin');
		$this -> email -> to($email);
		$this -> email -> subject('Thanks for expressing interest in Autovista.in');
		$body = $this -> load -> view('receiver_view.php', $paymentdata, TRUE);
		$this -> email -> message($body);
		$this -> email -> send();


?>


