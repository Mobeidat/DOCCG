<?php

/* Beautify the default login/register page */
function doc_default_login_register() {
	?>
<style type="text/css">
html, body {
	height: auto!important;
	min-height: 100vh!important;
}
.login {
	display: flex;
	justify-content: center;
	align-items: center;
background-image: url(<?php echo get_stylesheet_directory_uri().'/assets/images/bg.svg';
?>);
	background-position: center;
	background-repeat: no-repeat;
	background-size: cover;
	background-color: #3C80FF;
}
.login div#login {
	display: flex;
	justify-content: space-between;
	flex-wrap: wrap;
	width: auto;
	max-width: 320px;
	margin: 32px;
	padding: 16px;
	color: #666;
	text-align: center;
	background-color: white;
	border-radius: 16px;
}
.login div#login > * {
	width: 100%;
}
.login div#login h1 {
	margin-bottom: 20px;
}
.login div#login h1 a {
	overflow: inherit;
	width: auto;
	height: auto;
	margin-bottom: 0;
	font-size: 36px;
	color: #000;
	font-weight: bold;
	text-indent: 0;
	background-image: none;
}
.login #login_error, .login .message, .login .success {
	border-right: 4px solid #00a0d2;
	margin-left: 16px!important;
	margin-right: 16px!important;
	background-color: #fafafa!important;
	box-shadow: none!important;
}
.login #login_error {
	color: #dc3232;
	border-right-color: #dc3232;
	background-color: #ffeeee!important;
}
.login div#login form {
	margin-top: 0;
	padding: 16px;
	border: 0;
	box-shadow: none;
}
.login div#login form p {
	float: none;
}
.login div#login form input {
	padding: 10px 32px;
	font-size: 16px;
	text-align: center;
	background-color: var(--gray-2);
	border-radius: 64px;
	border: 0!important;
	outline: none!important;
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	-webkit-user-modify: read-write-plaintext-only;
}
.login div#login form input:focus {
	border: 0!important;
}
.login .button.wp-hide-pw {
	right: 8px!important;
	border: 0!important;
	outline: none!important;
}
.login div#login form p.forgetmenot {
	margin-bottom: 8px;
}
.login div#login form p.submit input#wp-submit {
	width: 100%;
	line-height: 1.5;
	background-color: #0071a1;
}
.login div#login form p.submit input#wp-submit:hover {
	background-color: #016087;
}
.login div#login p#nav, .login div#login p#backtoblog {
	width: auto;
	margin: 16px 0;
	padding: 0 16px;
}
.login #backtoblog a, .login #nav a {
	box-shadow: none!important;
}
.login .privacy-policy-page-link {
	margin: 0!important;
}
</style>
<?php
}
add_action( 'login_enqueue_scripts', 'doc_default_login_register' );

/* The default login registration page introduces css and js files
function doc_login_stylesheet() {
	wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/assets/css/back-logreg.css' );
	wp_enqueue_script( 'custom-login', get_stylesheet_directory_uri() . '/assets/js/back-logreg.js' );
}
add_action( 'login_enqueue_scripts', 'doc_login_stylesheet' );*/

/* Add setting password option to the default registration page */
function doc_register_fields() {
	?>
<p>
	<label for="password">
		<?php __('Password','doc_text');?>
	</label>
	<input type="password" name="password" id="password" class="input" value="" size="21">
</p>
<p>
	<label for="repeat_password">
		<?php __('Repeat password','doc_text');?>
	</label>
	<input type="password" name="repeat_password" id="repeat_password" class="input" value="" size="21">
</p>
<?php
}

function doc_extra_register_fields( $login, $email, $errors ) {
	if ( $_POST[ 'password' ] !== $_POST[ 'repeat_password' ] ) {
		$errors->add( 'passwords_not_matched', __( '<strong>Error</strong>: Password must be the same', 'mre-text' ) );
	}
	if ( strlen( $_POST[ 'password' ] ) < 6 ) {
		$errors->add( 'password_too_short', __( '<strong>Error</strong>: Password must be six digits', 'doc-text' ) );
	}
}
add_action( 'register_post', 'doc_extra_register_fields', 10, 3 );

function doc_extra_fields( $user_id ) {
	$userdata = array();
	$userdata[ 'ID' ] = $user_id;
	if ( $_POST[ 'password' ] !== '' ) {
		$userdata[ 'user_pass' ] = $_POST[ 'password' ];
	}
	$new_user_id = wp_update_user( $userdata );
	add_action( 'user_register', 'doc_extra_fields', 100 );

}
add_action( 'register_form', 'doc_register_fields' );
