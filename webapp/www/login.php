<?php
echo '
<DOCTYPE! html>
<html>
    <head>
        <title> Login Page </title>
        <link rel="stylesheet" href ="style.css"
    </head>
	<header>
		<a href = "index.php"> Home Page </a>
	</header>
    <body>

        <!-- TO DO: ADD ACTION.PHP FOR FORM -->
        <form>
            <label for "email">Email: </label>
            <input type="text" id="email" placeholder="Email" name ="email" pattern = "email" title = "username@domainname">
            <label for "password">Password: </label>
            <input type="password" id="password" placeholder="Password" name ="password">
            <input type="submit" value = "Submit">
        </form>

    </body>
</html>
';

?>