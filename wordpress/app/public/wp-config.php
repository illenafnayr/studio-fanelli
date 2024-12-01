<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'j%/CQT<8pHs&ja79/XLrNAI P)5$_o!Q!]pM|sI&&`MVv!=_:TUIKOOtR=cy|*-z' );
define( 'SECURE_AUTH_KEY',   '9k8-I05Y9]<Ibn; 8fe-v7]YP+T1?BHC+:HO6!$gC+x(i1=;4Ns`vr{Lq4+&V<F0' );
define( 'LOGGED_IN_KEY',     'g91Q$+gF^g+,N%M/*i-zh1gK}s.< .!wC?+2J&#j,ksDy+4hT&}rbECG86ke&e%a' );
define( 'NONCE_KEY',         'oV?yFER,5a;@t>&yh}E-JK8ySZ!uV<=Zs*3Tv&WcY5{3p:mh|f+9aQL>v*zBNq;l' );
define( 'AUTH_SALT',         '@VQ.>Pirq;:DJ63{eygXc<k;;KCNn,4qE lE,:ncsNm(~_^d~2gGTli=|`G/m#u-' );
define( 'SECURE_AUTH_SALT',  'WLe;li7@DR=Gq/(lFx:~@]UX4VG.W[jh>`]: 4DFBvm.f9V4A ZF_h|BA8v0:z~5' );
define( 'LOGGED_IN_SALT',    'e.JTMR yc[0}|gC@{}ek-@z1O}x4}ZiV09h0p+$^fL/b72Sf2a`&rGmgP7fmO!nQ' );
define( 'NONCE_SALT',        '-#ak^9v+23&N<uWW{Kb<*Bgb^@g56G4QVpE*2|%fH$SU`*t09dHRH^D@-aRj-Ku>' );
define( 'WP_CACHE_KEY_SALT', 'e_;P@r//IbW]mY{^?:+RS*xh*=bso[?0d:34YC!cbyd)fN#U|(oA&V,]y#C;$59Y' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
