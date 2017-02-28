<?php
/**
 * 
 * Config do sistema, que serão usadas para armazenas configs especiais
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */


class SsxConfig extends SsxModels
{
	/* default configs*/
	const SSX_DATA_SET = "_ssx_data_set";
	const SSX_USE_STMP = "_ssx_use_smtp";
	const SSX_USE_SEND_GRID = "_ssx_use_send_grid";
	const SSX_SMTP_DATA = "_ssx_smpt_data";
	const SSX_DEFAULT_USER_GROUP = "_ssx_default_user_group";
	
	const SSX_SEO_TITLE = "_ssx_seo_title";
	const SSX_SEO_KEYWORDS = "_ssx_seo_keywords";
	const SSX_SEO_DESCRIPTION = "_ssx_seo_description";
	
	const SSX_PAGES_ALLOW = "_ssx_pages_allow";
	const SSX_ACL_RULES = "_ssx_acl_rules";
	/* end default configs */
	
	public $link;
	
	public $table_name = "ssx_config";
	
	protected $label = "object_value";
	
	public static $configs;
	
	public $fields = array(
		'id'=>'string',
		'project_id'=>'int',
		'created_by'=>'string',
		'date_created'=>'datetime',
		'modified_by'=>'string',
		'date_modified'=>'datetime',
		'object_name'=>'string',
		'object_value'=>'string'
	);
	
	public static function loadConfig()
	{
		$SsxConfig = new SsxConfig();
		$SsxConfig->primary_key = "object_name";
		self::$configs = $SsxConfig->toOptions();
		
		$SsxConfig->primary_key = "id";
	}
	
	public function save($data)
	{
		return parent::saveValues($data);
	}
	
	public function getConfig($name)
	{
		$result = parent::filterData(array('object_name'=>$name,'project_id'=>Ssx::$project),true);
		return $result;			
	}
	
	/**
	 * Retorna a config salva no banco de dados
	 * retornará apenas o que está no campo VALUE
	 * @param string $name
	 * @param string $type JSON | SERIALIZED | STRING | INT
	 * @return mixed
	 */
	public static function get($name, $type='string',$force=false)
	{
		if($force)
		{
			$SsxConfig = new SsxConfig();
			$config = $SsxConfig->getConfig($name);
			
			if(!$config)
				return false;
			
			$config = $config['object_value'];
			
		}else{
			if(!isset(self::$configs[$name]))
				return false;
			
			$config = self::$configs[$name];
		}
		
		if($config)
		{
			switch($type)
			{
				case 'string':
					return (string)$config;
				break;
				case 'int':
					return (int)$config;
				break;
				case 'serialized':
					return @unserialize($config);
				break;
				case 'json':
					return @json_decode($config, true);
				break;
			}
		}
		return false;
	}
	
	/**
	 * Cria ou atualiza uma config no banco de dados
	 * 
	 * @param string $name nome da config
	 * @param string $value	valor da config
	 * @param boolean $replace se deve substituir uma já existe caso exista
	 * 
	 * @return string id da config criada
	 */
	public static function set($name, $value, $replace=true)
	{
		$SsxConfig = new SsxConfig();
		
		$config = $SsxConfig->getConfig($name);
		
		$data = array(
			'object_name'=>$name,
			'object_value'=>$value
		);
		
		if($config)
		{
			self::$configs[$data['object_name']] = $data['object_value'];
			
			if($replace)
			{
				$data['id'] = $config['id'];
				return $SsxConfig->save($data);
			}
			return $config['id'];
		}else{
			return $SsxConfig->save($data);
		}
		
	}
}