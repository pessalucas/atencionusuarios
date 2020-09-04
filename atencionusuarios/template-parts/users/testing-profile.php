
  <form name="my_registration" class="form-horizontal registraion-form" role="form">
  	<div class="input-wrapper">
  		<input type="text" name="full-name" id="full_name" value="" placeholder="Your Name" class="form-control" />
  	</div>
  	<div class="input-wrapper">
  		<input type="text" name="nick-name" id="nick_name" value="" placeholder="Your Nickname" class="form-control" />
  	</div>
  	<div class="input-wrapper">
  		<input type="email" name="email" id="email_optional" value="" placeholder="Email (Optional)" class="form-control" />
  	</div>
  	<div class="input-wrapper">
  		<input type="text" name="username" id="reg_username" value="" placeholder="Choose Username" class="form-control" />
  	</div>
  	<div class="input-wrapper">
  		<input type="password" name="password" id="reg_password" value="" placeholder="Choose Password" class="form-control" />
  	</div>
  
  	<?php wp_nonce_field( 'reg_new_user','new_user_registration', true, true ); ?>
  	
  	<div class="input-wrapper">
  		<?php do_action('register_form'); ?>
  		<input type="submit" class="btn btn-primary" id="btn-new-user" value="Register" />
  	</div>
  </form>

  <!-- Alert -->
  <div class="alert result-message"></div>
