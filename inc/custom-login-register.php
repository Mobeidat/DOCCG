<?php

/**
 * Beautify the default login/register page
 */
function doc_default_login_register() {
	?>
<style type="text/css">
html, body {
	height: auto!important;
	min-height: 100vh!important;
}
<?php $custom_logo_id = get_theme_mod( 'custom_logo' );
$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
if ( has_custom_logo() ) {
echo'.login div#login h1 a {
background-image: url('.esc_url( $logo[ 0 ] ).');
background-position: center;
background-repeat: no-repeat;
background-size: auto 100%;
}
';
}
else {
echo'.login div#login h1 a {
text-indent: 0;
background-image: none;
}
';
}
?> .login {
display: flex;
justify-content: center;
align-items: center;
background-image: url(<?php echo get_stylesheet_directory_uri().'/assets/images/bg.svg';
?>);
background-position: center;
background-repeat: no-repeat;
background-size: cover;
background-color: #232323;
}
.login div#login {
	display: flex;
	justify-content: space-between;
	flex-wrap: wrap;
	width: auto;
	max-width: 375px;
	overflow: hidden;
	margin: 16px;
	padding: 32px 8px;
	color: #555d66;
	background-color: white;
	border-radius: 10px;
}
.login div#login > * {
	width: 100%;
}
.login div#login h1, .login #login_error, .login .message, .login .success {
	margin: 0 8px 10px!important;
}
.login div#login h1 a {
	overflow: inherit;
	width: auto;
	height: auto;
	margin-bottom: 0;
	font-size: 40px;
	color: #191919;
	font-weight: bold;
}
.login #login_error, .login .message, .login .success {
	padding: 8px!important;
	border-right: 4px solid #00a0d2;
	background-color: #f1f7f9!important;
	box-shadow: none!important;
	text-align: center;
}
.login #login_error {
	color: #dc3232;
	border-right-color: #dc3232;
	background-color: #fff6f6!important;
}
.login div#login form {
	margin-top: 0;
	padding: 8px;
	border: 0;
	box-shadow: none;
}
.login div#login form p {
	display: block;
	margin-bottom: 8px;
}
.login div#login form input {
	margin: 0;
	padding: 10px 16px;
	font-size: 16px;
	background-color: #f1f7f9;
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
.login .forgetmenot, .login .pw-weak {
	margin-top: 8px!important;
}
.login .forgetmenot label, .login .pw-weak label {
	margin-bottom: 0!important;
}
.login div#login form p.submit input#wp-submit {
	width: 100%;
	line-height: 1.5;
	background-color: #0071a1;
	transition: .3s;
}
.login div#login form p.submit input#wp-submit:hover {
	background-color: #016087;
}
.login div#login p#nav, .login div#login p#backtoblog {
	width: auto;
	margin: 0 8px 10px;
	padding: 0;
}
.login #backtoblog a, .login #nav a {
	box-shadow: none!important;
}
.login .privacy-policy-page-link {
	margin: 0!important;
}

@media only screen and (min-width: 600px) {
.login div#login h1, .login #login_error, .login .message, .login .success {
	margin: 0 16px 16px!important;
}
.login #login_error, .login .message, .login .success {
	padding: 12px!important;
}
.login div#login form {
	padding: 16px;
}
.login div#login form p {
	margin-bottom: 16px;
}
.login div#login p#nav, .login div#login p#backtoblog {
	margin: 0 16px 16px;
}
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
		<?php _e('Password','doc-text');?>
	</label>
	<input type="password" name="password" id="password" class="input" value="" size="21">
</p>
<p>
	<label for="repeat_password">
		<?php _e('Repeat password','doc-text');?>
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
