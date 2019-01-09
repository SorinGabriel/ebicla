<?php
/**
 * Setările de bază pentru WordPress.
 *
 * Acest fișier este folosit la crearea wp-config.php în timpul procesului de instalare.
 * Folosirea interfeței web nu este obligatorie, acest fișier poate fi copiat
 * sub numele de "wp-config.php", iar apoi populate toate detaliile.
 * 
 * Acest fișier conține următoarele configurări:
 *
 * * setările MySQL
 * * cheile secrete
 * * prefixul pentru tabele
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php 
 *
 * @package WordPress
 */

// ** Setările MySQL: aceste informații pot fi obținute de la serviciile de găzduire ** //
/** Numele bazei de date pentru WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/mnt/e/Ubuntu/ebicla/wp-content/plugins/wp-super-cache/' );
define('DB_NAME', 'ebiclaro_wordpress');

/** Numele de utilizator MySQL */
define('DB_USER', 'ebicla');

/** Parola utilizatorului MySQL */
define('DB_PASSWORD', '1a2b3c');

/** Adresa serverului MySQL */
define('DB_HOST', 'localhost');

/** Setul de caractere pentru tabelele din baza de date. */
define('DB_CHARSET', 'utf8mb4');

/** Schema pentru unificare. Nu faceți modificări dacă nu sunteți siguri. */
define('DB_COLLATE', '');

/**#@+
 * Cheile unice pentru autentificare
 *
 * Modificați conținutul fiecărei chei pentru o frază unică.
 * Acestea pot fi generate folosind {@link https://api.wordpress.org/secret-key/1.1/salt/ serviciul pentru chei de pe WordPress.org}
 * Pentru a invalida toate cookie-urile poți schimba aceste valori în orice moment. Aceasta va forța toți utilizatorii să se autentifice din nou. 
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '2p^CJ1aM2K5aM_/GRkFS_66>AH[09VK3vkRW#.g8Gt*n?vbii~j_xu3|7,VYrvIj');
define('SECURE_AUTH_KEY',  '{]Iyh]f}$1nQ6_m+2-gg|-Y/aRk2!4}BCq[,>xj#rz6U)])UJP3oF{556Z7b;s6}');
define('LOGGED_IN_KEY',    'vj1blFgQm CD,c(,}Cj#zq;mF:LWcBkV*^=&1H$8+)M;m_Qgl+Ffp2c8LJGjmnl)');
define('NONCE_KEY',        'xk5`.}ou)lc]tP{@Vk-[r8w9:c1s_+5C51^BA>>/6_2:XHiXyzW6:tJ`YG&LP!,:');
define('AUTH_SALT',        'mH`;Ijo86)=%^8=cliI4RUw$2bLip0$FE$~aH{` D<.ck23?+q+T:xIKk#F;:@ A');
define('SECURE_AUTH_SALT', ')@L*2NSyuaX]#=uvy;.SUG7l6w7raQ9j(!R.@*,ATn 2A;A3C{B)<@AkD+Q]]<jo');
define('LOGGED_IN_SALT',   'l.:cIP8-<f!M|9IyC{?P[U/xAoZ!vZh9jPEFdTz>etif?f_~rfQfSXvFE H~(z_;');
define('NONCE_SALT',       '!#c]:%pp]:Z(2^LvJK8r[EB#:tDPGDzq@E=ED<JZOD>W.=FrS8`UpeZe1.4Q!v`@');

/**#@-*/

/**
 * Prefixul tabelelor din MySQL
 *
 * Acest lucru permite instalarea mai multor instanțe WordPress folosind aceeași bază de date
 * dacă prefixul este diferit pentru fiecare instanță. Sunt permise doar cifre, litere și caracterul liniuță de subliniere.
 */
$table_prefix  = 'wp_';

/**
 * Pentru dezvoltatori: WordPress în mod de depanare.
 *
 * Setează cu true pentru a permite afișarea notificărilor în timpul dezvoltării.
 * Este recomadată folosirea modului WP_DEBUG în timpul dezvoltării modulelor și
 * a șabloanelor/temelor în mediile personale de dezvoltare.
 *
 * Pentru detalii despre alte constante ce pot fi utilizate în timpul depanării,
 * vizitează Codex-ul.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress 
 */
define('WP_DEBUG', false);

/* Asta e tot, am terminat cu editarea. Spor! */

/** Calea absolută spre directorul WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Setează variabilele WordPress și fișierele incluse. */
require_once(ABSPATH . 'wp-settings.php');