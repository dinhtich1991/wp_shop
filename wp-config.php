<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sonnuoc');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'HAX5f8pL5+-`1#42<G+.I71pXm[yy@WpirVK}M[t?1{Z^dP>gMb^WHMC7&}Uw,I^');
define('SECURE_AUTH_KEY',  'YjMH]y$Tx]G*F%5I<?c s`QE#qru;-{5!+p:DD3@S0/rWk:TE#~?r?a2ci_9r8L-');
define('LOGGED_IN_KEY',    'YT++BS1bZ?c_9X4bS(-0LyM#mGk^C~g^Ag]seVX[_}PG%/CTJ)x5kM|Iiq$/UN1V');
define('NONCE_KEY',        'Lg|meS|xi55!U&]Ar8|zFadSW:`A+|%K|^ATkA?]yT98@J+gwOY=A_c(B/)pQVW4');
define('AUTH_SALT',        'Qy6XdzvY$nF|`@n,]YIM+:upggn,S$}N(3+j{^&t4#l;i:7fiKzKW6eP/Aoe{PLZ');
define('SECURE_AUTH_SALT', '9W(,FmJ?}?0R1wp^dtz1h1Y--B8ry<Uav+xgppHifsE2y++%?n@).(WIhd,|2rF.');
define('LOGGED_IN_SALT',   '+;UaBe@xB4r5zu[0;jpS,c5f| _(-,<!CCBir7_91b8oLKg-+q%>~mN&`0S{0e]0');
define('NONCE_SALT',       '1POgoz@CH?|y-mQ_NIjF=RMl&%=}gl{kJ;o0-Q;gqKOIyh N]v1wias!uwl(6]ST');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
