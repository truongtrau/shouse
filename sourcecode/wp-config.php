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
define('DB_NAME', 'shouse');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '98#gh:zJAe~&$:)vpw/Av,#yK:.e(iK6/`d7}p%frfIX}d3u(>?oSZEpme77Oe%O');
define('SECURE_AUTH_KEY',  'LG$;jl/V40n!t,GMV!<0%7%I=|BExxz!3yB.pB+MwW1?vxnEu+UfcMCVtJ>m}VFN');
define('LOGGED_IN_KEY',    'NdXwRn[1gMJYU(T^y:8!A%-Kn@|5wHS=^#Pu.&v)R&%%a}9$Lae<C>XFr{wP2w2=');
define('NONCE_KEY',        '~B{g7w>3%x#t6w97opy++:>j7GQ0!Kn::^mkGW8a(>+:`$k<L#g=?z7CLm@+9JZ{');
define('AUTH_SALT',        '8^P4 *,zS4C+0u%cLVg%|Q&@/+Llx5)AZyZGUh1*qWcI?}u}pPSRkzf.u_So#LB;');
define('SECURE_AUTH_SALT', '%!s3>Q;x4J3;za9f}[MO_geIb4U;,fUp5/{oQ0yoN^9e)IlY8M`C2Rf=BMQlMFgd');
define('LOGGED_IN_SALT',   '#mGMm%imLuz<rna00eNsH^L|_b/q3J14i_:iIQVy7%6]Akm34IMJCJs4wrA?ux<w');
define('NONCE_SALT',       '.aZhF/D%WJw77FUNMVxFlw7Pwu;u3M<(R6Ubg;4@th:8^QxLZvW.gm50al74px.~');

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
