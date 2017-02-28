<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

class TicketType extends SsxModels
{
	
	public $table_name = "ssx_ticket_type";
	
	public $prefix = "TT";
	
	public $label = "object_name";
	
	public $fields = array(
		'id'=>'int',
		'project_id'=>'int',
		'date_created'=>'datetime',
		'created_by'=>'string',
		'date_modified'=>'datetime',
		'modified_by'=>'string',
		'object_name'=>'string'
	);
	
	public function TicketType()
	{
		return parent::super();
	}
	
	public function save($data)
	{
		return parent::saveValues($data,false);
	}
	
	public function checkByName($name)
	{
		return parent::filterData(array('object_name'=>$name,'project_id'=>Ssx::$project));
	}
}