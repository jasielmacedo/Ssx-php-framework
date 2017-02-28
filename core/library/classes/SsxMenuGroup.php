<?php
/**
 * 
 * Classe de armazenamento de grupo de menus
 * 
 * @author jasiel Macedo <jasielmacedo@gmail.com>
 * @since 2013-09-23
 * @version 1.0
 *
 */
class SsxMenuGroup extends SsxModels
{
	public $link;
	
	public $table_name = "ssx_menu_group";
	
	public $fields = array(
		'id'=>'string',
		'date_created'=>'datetime',
		'created_by'=>'string',
		'date_modified'=>'datetime',
		'modified_by'=>'string',
		'slug'=>'string',
		'status'=>'int'
	);
	
	public $prefix = "MG";
	
	public function SsxMenuGroup()
	{
		parent::super();
	}
	
	public function save($data)
	{
		return parent::saveValues($data);
	}
	
	public function getMenuByGroup($id)
	{
		
	}
}