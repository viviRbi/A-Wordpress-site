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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
if(strstr($_SERVER['SERVER_NAME'],'localhost')){
	/** The name of the database for WordPress */
	define( 'DB_NAME', 'wordpress-test' );
	/** MySQL database username */
	define( 'DB_USER', 'root' );
	/** MySQL database password */
	define( 'DB_PASSWORD', '' );
	/** MySQL hostname */
	define( 'DB_HOST', 'localhost' );
}else{
	define( 'DB_NAME', 'db8qdskpertkyz' );
	define( 'DB_USER', 'us243hhwe8va6' );
	define( 'DB_PASSWORD', 'Thaovy95*' );
	define( 'DB_HOST', '127.0.0.1' );
}

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'JT|Ol(gCX7at3Px9ut}zx4z,ejCKg:[T=|;u)CC{7TMhp}0+dxn%=1~9 kpQ$(oh' );
define( 'SECURE_AUTH_KEY',  'Tvk`(uf8VKuYtJsQ1Ri:{=AEx3HESsT|76G(<L2SU9 GgD4}dj};ce M=&I?E4TH' );
define( 'LOGGED_IN_KEY',    'K]*p. d`S*)Qwr9Y$FL.w$!hSo7u+ZZ:{wNY!^,^{?e|Gi8HfJ2u1m$vCkL olYx' );
define( 'NONCE_KEY',        'y2VlzU|.BKcVmn}D#W0tDAhws +4c3=l`!~[iE6:[1 2+G=7*;4!kCJ6k{>8DDwH' );
define( 'AUTH_SALT',        '*=Fa52SPg2?#`*B&% oZaY,/V{>w3kK!Q`SB=[Ej1h+ZuF*Lm;~<DoWHSs-gJB-|' );
define( 'SECURE_AUTH_SALT', '&t8#4Mb]F!M!O19dj#nu5v>qUXs%6Qf},Wv1H)2I130Gi>w2SWi.TD!hxC^f>C8u' );
define( 'LOGGED_IN_SALT',   'c1|{I,;dG.w6do/:19|Gn7AWVd!P7^zpe:*D)v6>gc{fJa)/~vBI0LjB2T&4&}/_' );
define( 'NONCE_SALT',       'jD@d1KeHnIz,~vR|ma5mTR4dw{aNTcH4@yktW!an:c2-gv&oj(t}Utl7_d6}@x*9' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_test_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
