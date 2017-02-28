<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 *  @package Ssx
 *  @uses Ssx
 */

(defined("SSX") && get_class($this) == "Ssx") or die;


/**
 * Define o ID do projeto. Em caso de compartilhamento de banco mudar o id para ter dois ou mais Ssx funcionando na mesma base
 * @var int
 */
Ssx::$project = 1;

/**
 * Define os dados de banco
 * @var string
 */
$this->ssx_db_access['development'] = new SsxDbConfig();
$this->ssx_db_access['development']->ssx_db_type = 'mysql';
$this->ssx_db_access['development']->ssx_db_user = '3upjqC6Xk0Ggxlof/V5A6uiQrHTR0ibEin2Be5HPjOU=';
$this->ssx_db_access['development']->ssx_db_pass = '5qZwXXddkW8M9Ssoa1fDLYJglkfUuh0VpzacBbe+jlc=';
$this->ssx_db_access['development']->ssx_db_host = 'j8dOzBzqDGvrL4Hux3w2AV8IfxB3/WS1stqr7Y+YVzQ=';
$this->ssx_db_access['development']->ssx_db_name = 'pvl16fk6CfUwvPMIEmm+x936TtTpRl5GRttNRb8e7u4=';
$this->ssx_db_access['development']->ssx_hash_key = getenv('SSX_KEY');
$this->ssx_db_access['development']->ssx_hash_session_key = 'zhoTH9PHq$r06$E3x927BO5$bA$2s74';
$this->ssx_db_access['development']->ssx_db_port = 3306;

/**
 * Define se o ssx irá usar a flag SQL_CACHE em suas consultas.
 * @var string
 */
define("SSX_SQL_CACHE", true);

/**
 * Define o tema do projeto ssx
 * @var string
*/
define('SSX_THEME', 'default');

/**
 * Define a encoding do projeto
 * @var string
*/
define('SSX_ENCODING', 'UTF-8');

/**
 * Para exibir os erros gerados pela aplicação
 * @var boolean
*/
define('DB_ERROR_SHOW_WARNINGS', true);

/**
 * Para dropar a aplicacao em caso de erro
 * @var boolean
*/
define('DB_ERROR_DROP_APPLICATION', true);

/**
 * Para definir se havera variacao de linguagem
 * @var boolean
*/
define('SSX_LANGUAGES', false);

Ssx::$languages = array(
	'br',
	'en'
);

/**
 * define a linguagem default
 * @var string
 */ 
define('SSX_LANGUAGES_DEFAULT', 'br');