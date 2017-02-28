<?php
/**
 * 
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * 
 */

class SsxUsersPd extends SsxModels
{
	
	public $table_name = "ssx_user_pd";
	
	public $fields = array(
		'user_id'=>'string',
		'modified_by'=>'string',
		'date_modified'=>'datetime',
		'type'=>'int',
		'password'=>'string',
		'param_add'=>'string'
	);
	
	public $primary_key = "user_id";
	
	public function SsxUsersPd()
	{
		parent::super();
	}
	
	public function save($data)
	{
		if(isset($data['password']))
		{
			$data['password'] = parent::encryptPassword($data['password']);
		}
		
		return parent::saveValues($data,false);
	}
	
	public function checkPassword($user_id,$password)
	{
		$user = parent::filterData(array('user_id'=>$user_id),true);
		if($user)
		{
			if($user['type']=="1")
			{
				return parent::checkEncryptedPassword($password, $user['password']);
			}else
			{
				return ($user['password'] == $password);
			}
		}
		return false;
	}
}