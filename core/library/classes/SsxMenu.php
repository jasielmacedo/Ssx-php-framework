<?php
/**
 * Classe de administração de menus dentro do SSx
 * Menus que poderão ser usados tanto internamente como externamente
 * 
 * @author Jasiel macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @since 2013-09-23
 * 
 */

defined("SSX") or die;


class SsxMenu extends SsxModels
{
	public $link;
	
	public $tabla_name = "ssx_menu";
	
	public $fields = array(
		'id'=>'string',
		'date_created'=>'datetime',
		'crested_by'=>'string',
		'date_modified'=>'datetime',
		'modified_by'=>'string',
		'parent_id'=>'string',
		'title'=>'string',
		'menu_group_id'=>'string',
		'local'=>'int',
		'type'=>'int',
		'module'=>'string',
		'action'=>'string',
		'external_link'=>'string',
		'params'=>'string',
		'status'=>'int'
	);
	
	public $prefix = "MN";
	
	public function __construct()
	{
		parent::super();
	}
	
	public function save($data)
	{
		$data['parent_id'] = (isset($data['parent_id']) && $data['parent_id'])?$data['parent_id']:'';
		return parent::saveValues($data);
	}
	
	public function getFatherMenu($status=1,$menu_group_id="")
	{
		$args = array('status'=>$status,'parent_id'=>'');
		if($menu_group_id)
			$args = array('menu_group_id'=>$menu_group_id);
		return parent::filterData($args);
	}
	
	public function mountMenu($menu_group_id,$status=1, $check_permission=false)
	{
		$args = array(
			'status'=>$status,
			'menu_group_id'=>$menu_group_id,
		);
		
		$menus = parent::filterData($args);
		
		if($menus)
		{
			$representative = array();
			foreach($menus as $menu)
			{	
				if($check_permission && !SsxAcl::checkPermissionForAction($menu['module'],$menu['action'],($menu['local'] == 1?"project":"local")))
					continue;
				
				if(empty($menu['parent_id']))
				{
					$representative[$menu['menu_group_id']][$menu['id']] = $menu;
				}else{
					$representative[$menu['menu_group_id']][$menu['parent_id']]['child'][] = $menu;
				}
			}
			return $representative;
		}
		return false;
	}
}