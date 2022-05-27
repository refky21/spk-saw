<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------
| !SITE
|--------------------------------------------------------------------
*/
$config['app_name'] = 'Skripsi';
$config['app_title'] = 'Sistem Penunjang Keputusan';
$config['app_status'] = TRUE;		// 0 = offline, 1 = online
$config['app_set_cipher'] = 'MCRYPT_GOST';
$config['app_set_mode'] = 'MCRYPT_MODE_CFB';
$config['app_encrypt_mode'] = FALSE;		// 0 = false, 1 = true

/* config Security WIthout MCRYPT */
$config['s3cUr1ty'] = 'b5iu4d';

/* debug query db */
$config['app_debug'] = 0;	// 0 = false, 1 = true
$config['app_default_controller'] = 'auth/login';
$config['app_default_backend_controller'] = 'dashboard';



/* config url Scan QR Label */


/*
|--------------------------------------------------------------------------
| Database settings
| property prefix for system only on database table 
|  
|--------------------------------------------------------------------------
*/
$config['app_db_table_prefix'] = 'sys_';
$config['ref_db_table_prefix'] = 'ref_';

/*
|--------------------------------------------------------------------------
| Security settings
|
| The library uses PasswordHash library for operating with hashed passwords.
| 'phpass_hash_portable' = Can passwords be dumped and exported to another server. If set to FALSE then you won't be able to use this database on another server.
| 'phpass_hash_strength' = Password hash strength.
|--------------------------------------------------------------------------
*/
$config['auth_phpass_hash_portable'] = FALSE;
$config['auth_phpass_hash_strength'] = 8;

/*
|--------------------------------------------------------------------------
| Login settings
| 'login_record_ip' = Save in database user IP address on user login.
| 'login_record_time' = Save in database current time on user login.
|
| 'login_count_attempts' = Count failed login attempts.
| 'login_max_attempts' = Number of failed login attempts before CAPTCHA will be shown.
| 'login_attempt_expire' = Time to live for every attempt to login. Default is 24 hours (60*60*24).
| 'username_min_length' = Min length of user's username.
| 'username_max_length' = Max length of user's username.
| 'password_min_length' = Min length of user's password.
| 'password_max_length' = Max length of user's password.
|--------------------------------------------------------------------------
*/
$config['auth_login_by_username'] = TRUE;
$config['auth_login_by_email'] = TRUE;
$config['auth_login_record_ip'] = TRUE;
$config['auth_login_record_time'] = TRUE;
$config['auth_login_count_attempts'] = FALSE;
$config['auth_login_max_attempts'] = 5;
$config['auth_login_attempt_expire'] = 60*60*24;

$config['auth_username_min_length'] = 6;
$config['auth_username_max_length'] = 20;
$config['auth_password_min_length'] = 6;
$config['auth_password_max_length'] = 20;

/*
|--------------------------------------------------------------------------
| Auto login settings
|
| 'autologin_cookie_name' = Auto login cookie name.
| 'autologin_cookie_life' = Auto login cookie life before expired. Default is 2 months (60*60*24*31*2).
|--------------------------------------------------------------------------
*/
$config['auth_autologin_cookie_name'] = 'autologin';
$config['auth_autologin_cookie_life'] = 60*60*24*31*2;

/*
|--------------------------------------------------------------------------
| Captcha
|
| You can set captcha that created by Auth library in here.
| 'captcha_path' = Directory where the catpcha will be created.
| 'captcha_fonts_path' = Font in this directory will be used when creating captcha.
| 'captcha_font_size' = Font size when writing text to captcha. Leave blank for random font size.
| 'captcha_grid' = Show grid in created captcha.
| 'captcha_expire' = Life time of created captcha before expired, default is 3 minutes (180 seconds).
| 'captcha_case_sensitive' = Captcha case sensitive or not.
|--------------------------------------------------------------------------
*/
$config['auth_captcha_path'] = 'assets/captcha/';
$config['auth_captcha_fonts_path'] = 'assets/captcha/fonts/10.ttf';
$config['auth_captcha_width'] = 200;
$config['auth_captcha_height'] = 50;
$config['auth_captcha_font_size'] = 14;
$config['auth_captcha_grid'] = FALSE;
$config['auth_captcha_expire'] = 180;
$config['auth_captcha_case_sensitive'] = FALSE;
$config['auth_captcha_class'] = 'img-fluid';
/*
|--------------------------------------------------------------------------
| reCAPTCHA
|
| 'use_recaptcha' = Use reCAPTCHA instead of common captcha
| You can get reCAPTCHA keys by registering at http://recaptcha.net
|--------------------------------------------------------------------------
*/
$config['auth_use_recaptcha'] = FALSE;
$config['auth_recaptcha_public_key'] = '';
$config['auth_recaptcha_private_key'] = '';


/*
|--------------------------------------------------------------------------
| Cache application
|--------------------------------------------------------------------------
*/
$config['sys_cache_dir'] = APPPATH.'cache/';
$config['sys_cache_default_expires'] = 0;


/*
|--------------------------------------------------------------------------
| Template Parser Enabled
|--------------------------------------------------------------------------
|
| Should the Parser library be used for the entire page?
|
| Can be overridden with $this->template->enable_parser(TRUE/FALSE);
|
|   Default: TRUE
|
*/

$config['parser_enabled'] = FALSE;

/*
|--------------------------------------------------------------------------
| Template Parser Enabled for Body
|--------------------------------------------------------------------------
|
| If the parser is enabled, do you want it to parse the body or not?
|
| Can be overridden with $this->template->enable_parser(TRUE/FALSE);
|
|   Default: FALSE
|
*/

$config['parser_body_enabled'] = FALSE;

/*
|--------------------------------------------------------------------------
| Template Title Separator
|--------------------------------------------------------------------------
|
| What string should be used to separate title segments sent via $this->template->title('Foo', 'Bar');
|
|   Default: ' | '
|
*/

$config['title_separator'] = ' : ';

/*
|--------------------------------------------------------------------------
| Template Theme
|--------------------------------------------------------------------------
|
| Which theme to use by default?
|
| Can be overriden with $this->template->set_theme('foo');
|
|   Default: ''
|
*/

$config['theme'] = 'theadmin';

/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
|
| Where should we expect to see themes?
|
|	Default: array(APPPATH.'themes/' => '../themes/')
|
*/

$config['theme_locations'] = array(
	FCPATH.'themes/'
);

/*
|--------------------------------------------------------------------------
| Asset Directory
|--------------------------------------------------------------------------
|
| Absolute path from the webroot to your CodeIgniter root. Typically this will be your APPPATH,
| WITH a trailing slash:
|
|	/assets/
|
*/
// print_r(APPPATH_URI);
$config['asset_dir'] = config_item('base_url') . 'assets/';

/*
|--------------------------------------------------------------------------
| Asset URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	/assets/
|
*/

$config['asset_url'] = config_item('base_url') . 'assets/';

/*
|--------------------------------------------------------------------------
| Theme Asset Directory
|--------------------------------------------------------------------------
|
*/

/* $config['theme_asset_dir'] = APPPATH_URI . 'themes/'; ORIGINAL */
$config['theme_asset_dir'] = 'themes/';

/*
|--------------------------------------------------------------------------
| Theme Asset URL
|--------------------------------------------------------------------------
|
*/

$config['theme_asset_url'] = config_item('base_url') . 'themes/';

/*
|--------------------------------------------------------------------------
| Asset Sub-folders
|--------------------------------------------------------------------------
|
| Names for the img, js and css folders. Can be renamed to anything
|
|	/assets/
|
*/
$config['asset_img_dir'] = 'img';
$config['asset_js_dir'] = 'js';
$config['asset_css_dir'] = 'css';



/*
|--------------------------------------------------------------------------
| Uplaod path
|--------------------------------------------------------------------------
|
*/
$config['lampiran_upload_path']     = './upload/beasiswa/lampiran/';


/*
|--------------------------------------------------------------------------
| Session Variables Extends
|--------------------------------------------------------------------------
|
| 'sess_cookie_name'
|
|  The session cookie name, must contain only [0-9a-z_-] characters
|
*/
$config['sess_cookie_name'] = str_replace(' ', '_', preg_replace('/[^A-Za-z0-9\s]/', '', strtolower($config['app_name']))) . '_session';