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
define( 'DB_NAME', 'wp' );

/** MySQL database username */
define( 'DB_USER', 'admin' );

/** MySQL database password */
define( 'DB_PASSWORD', '111111' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'G&eeYAC4-Y^=L6]P_<Dk((4yJ!O?mAuPX#^ &2~zd^92L_EdSl(M=)7dpG_JFbqU' );
define( 'SECURE_AUTH_KEY',   'HTLYg*DaW&g7yZ9OD%O?SakaNfW<k9PX6Gt@Uq]C{&pce=I3}(;Mq:m:C[;f:R+&' );
define( 'LOGGED_IN_KEY',     'noyf1&Kq%0c|zN$oMXc|Yg{]Eouu{}j:wV4r|[~XR@2,42cFSoLj P}R&B 85h9-' );
define( 'NONCE_KEY',         '3(/go]Ak@.<zw6QBlF$@P87 juKTJZyWib4g:d:M=Rd3:CnNsy<6]<6:l}$I<}9[' );
define( 'AUTH_SALT',         'NgAOcOUC)MFBzoF1ibMvadR7T|7,HG6]CT=Tq8:AX#8LmhNyEPA:Tj8uAPLA9u1b' );
define( 'SECURE_AUTH_SALT',  '.]d5KU7&2!.m&iXaNneX8&%quUL}Hi`4T4JU|ZSHR{O7&]bCW8Ec|pg(]w9(6Iqz' );
define( 'LOGGED_IN_SALT',    '2XYiNH:c[g(sR9iysRdxuP}R($661!eK7.n3)O{ipB_yGRYwPa;~>1O|x`X(S{S6' );
define( 'NONCE_SALT',        '(C305 L!SWcr/FE+@[iN`um;X}v;n&lok%`yK>;[E?GU_2do rQM?txD+L<5cM{^' );
define( 'WP_CACHE_KEY_SALT', 'O.,~5u>7i w*!iK26]q!pPvBp#FrT?/ak7S?s?x(|M-%g RAcec.72 p!mEjGjsY' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
