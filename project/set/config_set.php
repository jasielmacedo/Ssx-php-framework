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
 * Gerar configurações no files/hash.php
 */
$this->ssx_db_access['development'] = new SsxDbConfig();
$this->ssx_db_access['development']->ssx_db_type = 'mysql';

// root
$this->ssx_db_access['development']->ssx_db_user = 'ZjWyv82ga6uSbuVu3GgJkAcYiWnjMZtWpKfjNWknDi8=';
// (sem senha)
$this->ssx_db_access['development']->ssx_db_pass = '0E29XFL5gDqQ6WXOteVToy0CP70q1oX6J9VMqOJdKz0=';
// 127.0.0.1
$this->ssx_db_access['development']->ssx_db_host = 'VNU/GyJ+bZTrqv0G3CLX9YB1b+ZBVFsPIKwqHNLow30=';
// ssx
$this->ssx_db_access['development']->ssx_db_name = 'kx1h8a6LrUHnHnwoZZu0L88hqjkBZz2vt87G+Y35ju4=';
$this->ssx_db_access['development']->ssx_hash_key = 'ZKZOPqy5WA@94s839oGAh6fDmF3IQ6w3';
$this->ssx_db_access['development']->ssx_hash_session_key = '2VPrco4bbJlLVaAXq1tI@ar33q]P2d28';
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