<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'pnext');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '/%Jhl)U/AV>f%d-@(3vMPMWyMs*uey7t5ir)=*1mV/xu1eENu743?x+]Vdej*w~k');
define('SECURE_AUTH_KEY',  '^q%97l3]fkiZwBCP2+R]bC x;:Gas.%?X<eh:(ET#m>4C~|m2di]u]%<(M.q{2/T');
define('LOGGED_IN_KEY',    '=!L0E7cUI/ON@ iJ]YvlvSrEB<? D<De9uPj4@elA3GF*{yQcF^QJ_m67p~30Mdv');
define('NONCE_KEY',        '7To-^A3;bar|e@OPM2q<DO+;tEj*m9q#y;?LYylYe8P$TIhwYvbkoQZXHBoWXqnc');
define('AUTH_SALT',        'c22E7`X`t%?cTx?p~Bj{?TU+B!:/JX2|o5ghldmR]?<DK;O8<fA_f2Q8m.FDYkel');
define('SECURE_AUTH_SALT', '_aL(}]pHmrO5UshZVfA#OEkpYWkjmqtk{GeMOWk`jh*~JZRvP{Kwy!_-t]CMfrqM');
define('LOGGED_IN_SALT',   '&A~gma]Ly&Qk6mKb&F4mrr@B3]Gx3%26[|#!t*?85l]>%4@28c(pye7GL}D]}.m.');
define('NONCE_SALT',       'gE#Z8}:og:@rTe&SjR,u{Po8V/Fi`FbV7|<{cI*XL1xb,=2U.@tA[2W^HV5Vgl q');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
