
<form id="login" action="login" method="post">
    <h1>Site Login</h1>
    <p class="status"></p>
    <label for="username">Username</label>
    <input id="username" type="text" name="username">
    <label for="password">Password</label>
    <input id="password" type="password" name="password">
    <input class="submit_button" type="submit" value="Login" name="submit">
	<?php
	 //wp_nonce_field( 'ajax-login-nonce', 'security' ); 
	 ?>
</form>
