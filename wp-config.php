<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'novat915_living_tree');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'z-E?2Ku|fcBbvs[f<F7TUbh8i{U;{H:I0lPO6&N95YQ9dn9R J*0U$_s:7W;2o?q');
define('SECURE_AUTH_KEY',  '=^Vf/85?)2.Drne|6ba! {lC-@,7H#tX<8B>k!sA+v.i0Hio4gmz$tA1k9Pqqmtf');
define('LOGGED_IN_KEY',    '-~@K*dyH>4e}vb~_<9#TJA%!>mhJ*CU-YLFYqNw=r(+&~Hus]uc}9}0L_vc+6ah(');
define('NONCE_KEY',        'Ec0OupV,I`JFZb/I4@{9AWA1<8E4y-WzY[&qq6!8 P kzU^/.0R[:7X<*GN$$R.W');
define('AUTH_SALT',        '2(6-yT(Z%&!v|H|B%|7vW[l8]aNQ,tXi&>9e=}Th./>5q5ZVg`020@]RRd5xQ#$w');
define('SECURE_AUTH_SALT', '8PDqk7?L(x=8g%<I@H+<bfd1Az-THZ0~6]vVDHSnuI(m2i-_$#T<B)iQT5:fN[<z');
define('LOGGED_IN_SALT',   'uHWu99-5#s}-58CtS*N9QnK$>NuEpa~l&kOoUjEc-HY fL:O:18#!pgH5>M&]{c%');
define('NONCE_SALT',       ',. +b9n}`;+XlD50]{j{=[v@,kp.SgdYT5llV7,rYpw|*JIVde^W6oJ_q+t.TQx$');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
