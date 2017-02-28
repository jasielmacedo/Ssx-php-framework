<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

class SsxPages extends SsxModels
{
	public $link;
	
	public $table_name = "ssx_pages";
	
	public $fields = array(
		'id'=>'string',
		'project_id'=>'int',
		'created_by'=>'string',
		'date_created'=>'datetime',
		'modified_by'=>'string',
		'date_modified'=>'datetime',
		'title'=>'string',
		'slug'=>'string',
		'content'=>'string',
		'seo_title'=>'string',
		'seo_keywords'=>'string',
		'seo_description'=>'string',
		'featured_image'=>'string',
		'status'=>'int'
	);
	
	public function SsxPages()
	{
		parent::super();
	}
	
	public function save($data)
	{
		return parent::saveValues($data);
	}

	public function delete($id)
	{
		return parent::definityDelete($id);
	}
	
	public function getBySlug($slug)
	{
		return parent::filterData(array('slug'=>$slug,'project_id'=>Ssx::$project), true);
	}
	
	public function getBySlugPublished($slug)
	{
		return parent::filterData(array('slug'=>$slug,'status'=>1,'project_id'=>Ssx::$project), true);
	}
	
	public static function getPage()
	{		
		$permission = SsxConfig::get(SsxConfig::SSX_PAGES_ALLOW);
		if(!$permission)
			return false;
		
		$param = Ssx::$request->fromFriendlyUrl(0);
		if($param == "pages")
			$param = Ssx::$request->fromFriendlyUrl(1);
			
		
		$SsxPages = new SsxPages();
		
		$page = $SsxPages->getBySlugPublished($param);
		if($page)
		{
			Ssx::$themes->set_theme_title($page['title']." |",false, true);
			return $page;
		}
		
		return false;
	}
}