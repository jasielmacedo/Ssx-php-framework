<?php
/**
 * 
 * @version 1.0
 * @author jasiel macedo <jasielmacedo@gmail.com>
 * 
 * 
 */
class SsxSessionLog extends SsxModels
{
	public $table_name = "ssx_session_log";
	
	public $fields = array(
		'id'=>'int',
		'project_id'=>'int',
		'date_created'=>'datetime',
		'created_by'=>'string',
		'session_id'=>'string',
		'user_ip'=>'string',
		'user_agent'=>'string',
		'status'=>'string'
	);
	
	public function __construct()
	{
		parent::super();
	}
	
	public function save($data)
	{
		return parent::saveValues($data,false);
	}
	
	public function addLog($log)
	{
		$data = $this->collect();
		$data['status'] = $log;
		return $this->save($data);
	}
	
	public function collect()
	{
		return array(
			'session_id'=>session_id(),
			'user_ip'=>client_ip(),
			'user_agent'=>client_user_agent()
		);
	}
}