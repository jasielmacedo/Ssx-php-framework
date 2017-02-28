<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.6.0
 */

defined("SSX") or die;

class SsxModels extends SsxFilterDispatcher implements SsxModelsInterface
{
	/**
	 * Link de banco de dados
	 * @var SsxDatabase
	 */
	public $link;
	
	/**
	 * Todos os fields da tabela em questão
	 * @var array
	 */
	public $fields;
	
	/**
	 * Nome da tabela que a classe comanda
	 * @var string
	 */
	public $table_name;
	
	/**
	 * Define qual é o prefixo da tabela a ser usado em caso de chamadas mais específicas como de inner join de tabelas
	 * @var string
	 */
	public $prefix = "DF";
	
	/**
	 * Define qual é o primary key da tabela em questão
	 * (Ainda não é possível ter dois ou mais primary keys)
	 * @var string
	 */
	protected $primary_key = "id";
	
	/**
	 * Nome do campo na tabela que podera ser usado para gerar array de chave => valor (options)
	 * @var string
	 */
	protected $label = "name";
	
	/**
	 * Usado para construção de queries com SQL_CACHE = true
	 * @var unknown
	 */
	private $cache = "";
	
	/**
	 * Objeto a ser retornado caso prefira trabalhar com objetos
	 * @var mixed
	 */
	private $itemObject = null;
	
	/**
	 * Construtores
	 */
	public function __construct(){ SsxModels::super(); }
    public function SsxModels(){ SsxModels::super(); }
	
    /**
     * Configura as ações nessárias para a classe
     */
	protected function super()
	{		
		if(!Ssx::$link)
		{
			die("SSX MODEL: LINK NAO DEFINIDO");
		}
		$this->link = &Ssx::$link;
		
		if(!$this->table_name)
			die("SSX MODEL: TABELA NÃO DEFINIDA");
			
		if(defined('SSX_DB_PREFIX_TABLE') && SSX_DB_PREFIX_TABLE)
			$this->table_name = constant('SSX_DB_PREFIX_TABLE')."_".$this->table_name;
		
		if(defined('SSX_SQL_CACHE') && SSX_SQL_CACHE)
			$this->cache = "SQL_CACHE";
	}
	
	/* função descontinuada */
	public function checkLink(&$link)
	{
		if(!$link)
		{
			die("SSX MODEL: LINK NAO DEFINIDO");
		}
		$this->link = &$link;
		
		if(defined('SSX_DB_PREFIX_TABLE') && SSX_DB_PREFIX_TABLE)
			$this->table_name = constant('SSX_DB_PREFIX_TABLE')."_".$this->table_name;
	}
	
	public function setObject($object)
	{
		if($object && class_exists($object))
			$this->itemObject = $object;
		return;
	}
	
	public function saveValues($values,$generate_guid=true, $editing_check=true)
	{
		if(!is_array($values))
		{
 			die("SSX: Dados inconsistentes a serem salvos");
 		}   
 		
 		$editing = false;
 		
 		if(isset($values[$this->primary_key]) && $values[$this->primary_key] && $editing_check)
 		{
 			$editing = true;
 			if(!SsxModels::fillModule_d($values[$this->primary_key]))
 				$editing = false;
 		}

 		SsxModels::prepare($values);
 		
 		if(SsxModels::checkFieldExists('date_modified'))
 		{
 		   $values['date_modified'] = "now()";
        }     
 		   	
                
 		if($editing)
 		{
 		  $sql = "UPDATE $this->table_name SET ";
          
          $where = " WHERE ".$this->primary_key." = :".$this->primary_key;	 
 	
   		  foreach($values as $field => $value)
   		  {
   		  	  // so continua se o campo estiver listado no array fields
   		  	  if(SsxModels::checkFieldExists($field))
   		  	  {
		   		 $sql .= " $field = :$field,";
	   		  }
   		  } 

   		  $sql = substr($sql, 0,strlen($sql)-1);

          $sql .= $where;
          $statement = $this->link->prepare($sql);
                 
          // define o valor a seus respetivos campos
          foreach($values as $field => $value)
   		  {
   		  		if(!isset($this->fields[$field]))
   		  			continue;
   		  		
   		  		if($this->fields[$field]=='int')
                    $param = PDO::PARAM_INT;
                else
                	$param = PDO::PARAM_STR;
                	
                if($value == "now()")
                	$value = date("Y-m-d H:i:s");
                
   		  		$statement->bindValue(":$field", $value, $param);
   		  }         
 		}else
 		{ 		  
 		   if(SsxModels::checkFieldExists('deleted'))
 				$values['deleted']=isset($values['deleted']) && $values['deleted']?$values['deleted']:'0';
 			
 		  //Campos básicos: não precisam ser passados, uma vez que serão substituídos
 		  if(SsxModels::checkFieldExists($this->primary_key))
 		  { 
	 		  if($generate_guid)
	 		     $values[$this->primary_key] = isset($values[$this->primary_key]) && $values[$this->primary_key]?$values[$this->primary_key]:SsxModels::create_guid();
	 		  else
	 		     $values[$this->primary_key] = isset($values[$this->primary_key]) && $values[$this->primary_key]?$values[$this->primary_key]:"";
 		  }
 		  
 		  if(SsxModels::checkFieldExists('date_created'))
 		  {
 		     $values['date_created'] = "now()";
 		  }
 		  
 		  if(SsxModels::checkFieldExists('deleted'))
 		     $values['deleted'] = '0';	
          
          $fields="";
          $vals="";
          foreach($values as $field => $value)
          {
	          	if(SsxModels::checkFieldExists($field))
	   		  	{            
			    	$fields .= ",$field";
			    	$vals .= ",:$field";
	   		  	}
          } 
          
          $fields = substr($fields,1,strlen($fields)-1);
		  $vals = substr($vals,1,strlen($vals)-1);

          $sql = "INSERT INTO {$this->table_name} ($fields) VALUES($vals)"; 		  
          
          $statement = $this->link->prepare($sql);
     
		  foreach($values as $field => $value)
		  {                           
              if(SsxModels::checkFieldExists($field))
              {  
              	    if($this->fields[$field]=='int')
	                    $param = PDO::PARAM_INT;
	                else
	                	$param = PDO::PARAM_STR;
	                	
	                if($value == "now()")
	                	$value = date("Y-m-d H:i:s");
	                
	   		  		$statement->bindValue(":$field", $value, $param);
              }
          }
 		}    
 				
 		$result = $this->link->cmd($statement);
 		if(!$result)
 			return false;

 		if(empty($values[$this->primary_key]) && SsxModels::checkFieldExists($this->primary_key))
 		{
			$GUID 		  = $this->link->prepare("SELECT LAST_INSERT_ID( `".$this->primary_key."` ) AS `last_id` FROM {$this->table_name} ORDER BY LAST_INSERT_ID( `".$this->primary_key."` ) DESC");
			$result 	  = $this->link->getone($GUID);
			
			$values[$this->primary_key] = $result['last_id'];
 		}	
 		
 		return parent::dispatchFilter(__METHOD__, $values[$this->primary_key]);//Retorno ID do registro inserido ou alterado	
	}
	
	protected function prepare(&$data)
	{
		$user_id = SsxUsers::getUser(true);
		if(!$user_id)
			$user_id = Ssx::$project_data->g_id;	
		
		if(!isset($data[$this->primary_key]) || !$data[$this->primary_key])
		{
			if(SsxModels::checkFieldExists('created_by'))
			{
				$data['created_by'] = $user_id;
			}
		}
		
		if(SsxModels::checkFieldExists('modified_by'))
		{
			$data['modified_by'] = $user_id;
		}
		
		
		if(SsxModels::checkFieldExists('project_id'))
			$data['project_id'] = Ssx::$project;

	}
	
	public function fill($id,$creators=true, $args=array()) {
		$bind = array();
		
		$args['fields'][$this->prefix] = $this->field_array();
		$args['AND'][] = array('field'=>$this->prefix . '.' .$this->primary_key,'compare'=>'=','value'=>$id);
		
		if(SsxModels::checkFieldExists('created_by'))
		{
			$args['JOIN']['type'] = "inner";
			$args['JOIN']['conditions'][] = array('prefix'=>'SC','table'=>'ssx_user','field'=>array('id'=>array($this->prefix =>'created_by'),'deleted'=>'0'));
			$args['fields']['SC'] = array('`name` AS `created_by_name`');
		}
		
		if(SsxModels::checkFieldExists('modified_by'))
		{
			$args['JOIN']['type'] = "inner";
			$args['JOIN']['conditions'][] = array('prefix'=>'SM','table'=>'ssx_user','field'=>array('id'=>array($this->prefix =>'modified_by'),'deleted'=>'0'));
			$args['fields']['SM'] = array('`name` AS `modified_by_name`');
		}
		
		if(SsxModels::checkFieldExists('deleted'))
		{
			$args['AND'][] = array('field'=>$this->prefix . '.deleted','compare'=>'=','value'=>'0');			
		}
		
		if(SsxModels::checkFieldExists('project_id'))
		{
			$args['AND'][] = array('field'=>$this->prefix.'.project_id','compare'=>'=','value'=>Ssx::$project);
		}
		
		return parent::dispatchFilter(__METHOD__,SsxModels::getDatabyField($args, true));
	}
	
	private $fields_list_string = "";
	
	public function field_string($prefix_table="")
	{
		if(!$this->fields || !is_array($this->fields))
			return "*";
		
		if($this->fields_list_string)
			return $this->fields_list_string;
		
		$fields = array_keys($this->fields);	
			
		if(!empty($prefix_table))
			$prefix_table = $prefix_table . ".";	
			
		$str = implode("`,".$prefix_table."`", $fields);
		
		$this->fields_list_string = parent::dispatchFilter(__METHOD__, $prefix_table."`".$str."`");
		
		return $this->fields_list_string;
	}
	
	public function field_array()
	{
		$fields = array_keys($this->fields);
		

		if($fields[0] === 0)
			return $this->fields;
		
		
		return $fields;
	}
	
	public function count($query=null)
	{
		$bind = array();
		
		if(SsxModels::checkFieldExists('deleted'))
			$query['AND'][] = array('field'=>$this->prefix . '.deleted','compare'=>'=','value'=>'0');
		
		
		if(SsxModels::checkFieldExists('project_id'))
			$query['AND'][] = array('field'=>$this->prefix.'.project_id','compare'=>'=','value'=>Ssx::$project);
		
		$prefix = "";
		if($this->prefix)
		{
			$prefix = " AS ". $this->prefix;
		}
		
		$sql = "SELECT ".$this->cache." count( ".$this->prefix.".`id` ) AS `total` FROM {$this->table_name} ".$prefix." ";
		
		SsxModels::translateJoin($query,$sql);
		
		SsxModels::translateWhere($query,$sql,$bind);
		
		$statement = $this->link->prepare($sql);
		
		foreach($bind as $key => $row)
		{
			$statement->bindValue(":$key", $row,($this->fields[$key]=="int"?PDO::PARAM_INT:PDO::PARAM_STR));
		}
		
		return parent::dispatchFilter(__METHOD__, $this->link->getone($statement));
	}
	
	protected function simpleWhere(&$args, &$bind)
	{
		if(!$args || !is_array($args))
			return "";
			
		$where = "";
		
		if($args)
		{
			$kCount = 0;
			foreach($args as $queryField => $queryValue)
			{
				$fd = $queryField;
				if(strpos($queryField,".")!==false)
				{
					$fd = explode(".",$queryField);
					$fd = end($fd);
				}
				
				if($kCount == 0)	
					$where .= sprintf(" `%s` = :%s ", $queryField, $fd);
				else
					$where .= sprintf(" AND `%s` = :%s ", $queryField, $fd);
				$kCount=1;
				
				
				
				$bind[$fd] = $queryValue;
			}
		}
		return parent::dispatchFilter(__METHOD__, $where);
	}
	
	/**
	 * Retorna uma simples consulta de comparação de = apenas
	 * @param array $args
	 * @param boolean $one
	 * @example 
	 * $args = array(
	 * 	'name'=>'example',
	 * 	'email'=>'example@teste.com'
	 * );
	 */
	public function filterData($args="", $one=false, $addEnd="")
	{
		$bind = array();
		$where = SsxModels::simpleWhere($args,$bind);
		
		if($where)
		{
			$where = "WHERE " . $where;
		}
		
		$fields_string = SsxModels::field_string();
		
		$sql = "SELECT ".$this->cache." {$fields_string} FROM {$this->table_name} $where";
		
		if($addEnd)
			$sql .= $addEnd;
		
		$statement = $this->link->prepare($sql);
		
		foreach($bind as $key => $row)
		{
			$statement->bindValue(":$key", $row,($this->fields[$key]=="int"?(PDO::PARAM_INT):(PDO::PARAM_STR)));
		}
		
		if($one)
			$return = $this->link->getone($statement, $this->itemObject);
		else
			$return = $this->link->get($statement,$this->itemObject);
			
		return parent::dispatchFilter(__METHOD__,$return);
	}
	
	public function delete($params) 
	{
		if(!is_array($params))
			return;
			
		$sql = "DELETE FROM `". $this->table_name . "` ";
		
		$bind = array();
		
		if($params)
		{
			$sql .= "WHERE ";
			$kCount = 0;
			foreach($params as $key => $value)
			{
				if(SsxModels::checkFieldExists($key))
				{
					$fd = $key;
					if(strpos($key,".")!==false)
					{
						$fd = explode(".",$key);
						$fd = end($fd);
					}
					
					if($kCount == 0)
						$sql .= sprintf(" `%s` = :%s ",$key,$fd);
					else
						$sql .= sprintf(" AND `%s` = :%s ",$key,$fd);
						
					$kCount++;
	
					$bind[$fd] = $value;
				}
			}
		}
		
		$statement = $this->link->prepare($sql);
		
		foreach($bind as $key => $row)
		{
			$statement->bindValue(":$key", $row,($this->fields[$key]=="int"?PDO::PARAM_INT:PDO::PARAM_STR));
		}
		
		return parent::dispatchFilter(__METHOD__,$this->link->cmd($statement));
	}
	
	public function deleteFlag($id)
	{
		return parent::dispatchFilter(__METHOD__, SsxModels::saveValues(array($this->primary_key=>$id,'deleted'=>'1')));
	}
	
	public function definityDelete($id){
		return parent::dispatchFilter(__METHOD__,SsxModels::delete(array($this->primary_key=>$id)));
	}
	
	/**
	 * Verifica se o campo existe na lista de fields
	 * @param string $field
	 */
	public function checkFieldExists($field)
	{
		$check = true;
		$aFields = array();
		
		if(is_string($field))
			$aFields = explode(',',$field);
			
		if(is_array($field))
			$aFields = $field;
		
		if($aFields && is_array($aFields) && count($aFields)>0)
		{
			foreach($aFields as $row)
			{
				if(!isset($this->fields[$row]) || !$this->fields[$row])
					$check = false;
			}
			
			return parent::dispatchFilter(__METHOD__,$check);
		}
		return false;
	}
	
	/**
	 * Monta uma paginação apartir de uma consulta ou parametros
	 * 
	 * @param array $params[opcional]
	 * @param int $limit
	 * @return array
	 */
	public function mountPagination($params=null, $limit)
	{
		$count = SsxModels::count($params);
		
		if($count && $count['total'] && $count['total']>$limit)
		{
			$pages = Math::Ceil($count['total'] / $limit); 
			
			$pg_arr = array();
			
			for($i = 0; $i < $pages; $i++)
			{
				$pg_arr[$i] = $i+1;
			}
			return parent::dispatchFilter(__METHOD__,$pg_arr);
		}
		return false;
	}
	
	/**
	 * Monta paginação de paginação, sempre centralizando o 
	 * item da pagina em questão
	 * 
	 * @param array $pagination
	 * @param int $corner[opcional]
	 * @return array
	 */
	public function pg2pg($pagination, $corner=4, $page)
	{
		$page++;
		
		if(!is_array($pagination))
			return $pagination;
			
		$total = count($pagination);
		
		$view = ($corner * 2) + 1;
		if($view > $total)
			$view = $total;
		
		
		$max = $total - $page;
		
		if($max < 0)
			$max = 0;
		$min = $page-1;

		if($page > $corner && $page < $total-$corner)
		{
			if($max > $corner)
				$max = $corner;
				
			if($min > $corner)
				$min = $corner;
		}else{
			if($max > $min)
				$max = ($view-1)-$min;
			else
				$min = ($view-1)-$max;
		}
			
		$new_pg = array();

		
		$key = 0;
		for($i = $min; $i > 0; $i--)
		{
			$new_pg[$key] =  $pagination[(($page+1)-($i+1))-1];
			$key++;
		}
		
		$new_pg[$key] = $page;
		$key++;
		
		for($i = 0; $i < $max; $i++)
		{
			$new_pg[$key] = $pagination[($page+($i+1))-1];
			$key++;
		}
		
		
		return parent::dispatchFilter(__METHOD__,$new_pg);
	}
	
	/**
	 * Trata o array para montar a string do banco de dados
	 * 
	 * @param $queryData array|nominal
	 * @return string
	 */
	protected function translateWhere(&$queryData, &$context, &$bind)
	{
		if(!is_array($queryData))
			return;
		
		foreach($queryData as $queryKey => $queryItems)
		{
			if($queryKey == "AND" || $queryKey == "OR")
			{
				$kCount = 0;
				foreach($queryItems as $queryTableValues)
				{
					$fd = $queryTableValues['field'];
					if(strpos($queryTableValues['field'],".")!==false)
					{
						$fd = explode(".",$queryTableValues['field']);
						$fd = end($fd);
					}
					
					if($kCount == 0)
					{
						$context .= " WHERE ";
						$context .= sprintf(" %s %s :%s ",$queryTableValues['field'],$queryTableValues['compare'],$fd);
					}else
						$context .= sprintf(" %s %s %s :%s ",$queryKey,$queryTableValues['field'],$queryTableValues['compare'],$fd);
					
					$kCount=1;
					
					
					$bind[$fd] = $queryTableValues['value'];
				}
			}else if($queryKey == "ORDER")
			{
				$context .= " ORDER BY ".$queryItems;
			}else if($queryKey == "GROUP")
			{
				$context .= " GROUP BY ".$queryItems;
			}else if($queryKey == "LIMIT")
			{
				$context .= " LIMIT ".$queryItems;
			}
		}
	}
	
	/**
	 * Trata o array para montar a string de Join da query
	 * @param array $queryData
	 * @return string
	 */
	protected function translateJoin(&$queryData, &$context)
	{
		if(!is_array($queryData))
			return;
		
		foreach($queryData as $queryKey => $queryItems)
		{
			if($queryKey == "JOIN")
			{
				$type = "INNER JOIN";
				if(isset($queryItems['type']) && $queryItems['type'])
				{
					switch($queryItems['type'])
					{
						case "inner":
							$type = " INNER JOIN ";
						break;
						case "left":
							$type = " LEFT JOIN ";
						break;
						default:
							$type = " JOIN ";
						break;
					}
				}
				if(isset($queryItems['conditions']) && $queryItems['conditions'])
				{
					foreach($queryItems['conditions'] as $queryTableValues)
					{
						$px = $queryTableValues['prefix'];
						if(is_array($queryTableValues['field']))
						{
							$context .= $type . " `" . $queryTableValues['table'] . "` AS `" . $px . "` ON ";
							
							$k = 0;
							foreach($queryTableValues['field'] as $fieldKey => $fieldValue)
							{
								if($k > 0)
									$context .= " AND ";
								$context .= "`" . $px . "`.`" . $fieldKey . "` = ";
								if(is_string($fieldValue))
								{
									$context .= "'".$fieldValue."'";
								}else if(is_array($fieldValue))
								{
									foreach($fieldValue as $other => $other_value)
									{
										$context .= "`" .$other . "`.`".$other_value."`";
										break;
									}
								}
								$k++;
							}	
						}
					}
				}
			}
		}
	}
	
	protected function translateFields(&$queryData, &$context)
	{
		if(!is_array($queryData))
			return $context .= SsxModels::field_string($this->prefix);		
		
		$field_found = false;
		foreach($queryData as $queryKey => $queryItems)
		{
			if($queryKey == "fields")
			{
				$fields = array();
				foreach($queryItems as $queryTablePrefix => $queryTableValues)
				{
					if(is_array($queryTableValues))
					{
						foreach($queryTableValues as $queryFieldValue)
						{
							if(is_string($queryTablePrefix))
								$fields[] = sprintf(" `%s` . %s ",$queryTablePrefix,$queryFieldValue);
							else						
								$fields[] = sprintf("  %s ",$queryFieldValue);
						}
					}else
					{
						if(is_string($queryTablePrefix))
							$fields[] = sprintf(" `%s` . %s ",$queryTablePrefix,$queryTableValues);
						else						
							$fields[] = sprintf("  %s ",$queryTableValues);
					}
				}
				$context .= implode(",",$fields);
				$field_found = true;
			}
		}
		
		if(!$field_found)
		{
			$context .= SsxModels::field_string($this->prefix);
		}
	}
	
	
	public function strFilterData($queryData=null,&$bind)
	{		
		$sql = "SELECT ".$this->cache." ";
		
		$prefix = "";
		if($this->prefix)
		{
			$prefix = " AS ". $this->prefix;
		}
		
		SsxModels::translateFields($queryData,$sql);
		
		$sql .= " FROM {$this->table_name} ".$prefix." ";
		
		SsxModels::translateJoin($queryData, $sql);
		
		SsxModels::translateWhere($queryData,$sql,$bind);
		
		return parent::dispatchFilter(__METHOD__,$sql);
	}

	public function getAll($order_by=null, $order_sort='ASC', $limit=0, $offset=0, $queryData=null, $creators = false)
	{
		$bind = array();
		
		if($creators)
		{
			if(!isset($queryData['fields']))
			{
				$queryData['fields'] = array($this->prefix =>$this->field_array());
			}
			
			if(SsxModels::checkFieldExists('created_by'))
			{
				$queryData['JOIN']['type'] = "inner";
				$queryData['JOIN']['conditions'][] = array('prefix'=>'SC','table'=>'ssx_user','field'=>array('id'=>array($this->prefix =>'created_by'),'deleted'=>'0'));
				$queryData['fields']['SC'] = array('`name` AS `created_by_name`');
			}
			
			if(SsxModels::checkFieldExists('modified_by'))
			{
				$queryData['JOIN']['type'] = "inner";
				$queryData['JOIN']['conditions'][] = array('prefix'=>'SM','table'=>'ssx_user','field'=>array('id'=>array($this->prefix =>'modified_by'),'deleted'=>'0'));
				$queryData['fields']['SM'] = array('`name` AS `modified_by_name`');
			}
		}
		
		if(SsxModels::checkFieldExists('project_id'))
			$queryData['AND'][] = array('field'=>$this->prefix.'.project_id','compare'=>'=','value'=>Ssx::$project);
		
		$sql = SsxModels::strFilterData($queryData, $bind);
		
		if($order_by)
			$sql .= " ORDER BY ".$order_by. " ".$order_sort;
			
		if(isset($limit) && $limit>0)
		{
			$offset = $limit * $offset;
			$sql .= " LIMIT ".$offset.",".$limit;
		}
		
		$sql = parent::dispatchFilter('ssx_sql_getall',$sql);
		
		$statement = $this->link->prepare($sql);
		
		foreach($bind as $key => $row)
		{
			$statement->bindValue(":$key", $row,($this->fields[$key]=="int"?PDO::PARAM_INT:PDO::PARAM_STR));
		}
		
		return parent::dispatchFilter(__METHOD__,$this->link->get($statement, $this->itemObject));
	}
	
	/**
	 * Alias for getAll Function
	 * 
	 * @param string $order_by
	 * @param ASC|DESC $order_sort
	 * @param int $limit
	 * @param int $offset
	 * @param ssxargs $queryData
	 * @param bool $creators
	 */
	public function fetch($queryData=null, $order_by=null, $order_sort='ASC', $limit=0, $offset=0 , $creators=false)
	{
		return SsxModels::getAll($order_by, $order_sort, $limit, $offset, $queryData, $creators);
	}
	
	public function encryptPassword($password)
	{
		// criptografia 
		return parent::dispatchFilter(__METHOD__,SsxUtils::$phpass->HashPassword($password));
	}
	
	public function checkEncryptedPassword($confirm, $storedPassword)
	{
		return SsxUtils::$phpass->CheckPassword($confirm, $storedPassword);
	}
	/**
	 * Traz um ou mais resultados de uma consulta em expecífico apartir de uma query de parametros
	 * @param array $queryData
	 * @param boolean $one
	 * @example 
	 * $queryData = array(
	 * 	  'AND'=>array(
	 * 	  	array('field'=>'name', 'compare'=>'LIKE', 'value'=>'%example%'),
	 * 		array('field'=>'email', 'compare'=>'=', 'value'=>'example@teste.com'
	 *    )
	 * );
	 */
	public function getDatabyField($queryData, $one=false, $addEnd=""){
		
		$bind = array();
		$sql = SsxModels::strFilterData($queryData,$bind);
		
		if($addEnd)
			$sql .= $addEnd;
		
		$statement = $this->link->prepare($sql);
		
		foreach($bind as $key => $row)
		{
			
			$statement->bindValue(":$key", $row,(isset($this->fields[$key]) && $this->fields[$key]=="int"?PDO::PARAM_INT:PDO::PARAM_STR));
		}
		
		$result = false;
		
		if($one)
			$result = $this->link->getone($statement, $this->itemObject);
		else
			$result = $this->link->get($statement, $this->itemObject);
		return parent::dispatchFilter(__METHOD__,$result);
	}
	
	public function toOptions($args=array(), $complex=false)
	{		
		if($complex)
		{
			if(SsxModels::checkFieldExists('project_id'))
				$args['AND'][] = array('field'=>$this->prefix.'.project_id','compare'=>'=','value'=>Ssx::$project);
			$data = SsxModels::getDatabyField($args);
		}else
		{
			if(SsxModels::checkFieldExists('project_id'))
				$args['project_id'] = Ssx::$project;
			$data = SsxModels::filterData($args, false);
		}
		
		if($data)
		{
			$returning = array();
			for($i = 0; $i < count($data); $i++)
			{
				$returning[$data[$i][$this->primary_key]] = $data[$i][$this->label];
			}
			return $returning;
		}
		return array();
	}

    protected function fillModule_d($module_id)
    {
    	$fields = SsxModels::field_string();
    	
    	$sql = "SELECT ".$this->cache."
 				 {$fields}
 				FROM 
 				  {$this->table_name}
 				WHERE
 				  ".$this->primary_key." = :$this->primary_key;		
 			   "; 		
		$statement = $this->link->prepare($sql);
		$statement->bindValue(":".$this->primary_key, $module_id,($this->fields[$this->primary_key]=="int"?PDO::PARAM_INT:PDO::PARAM_STR));
 				  
 		return parent::dispatchFilter(__METHOD__,$this->link->getone($statement));
    }

    protected function create_guid()
    {
    	return SsxUtils::guid();
    }
}