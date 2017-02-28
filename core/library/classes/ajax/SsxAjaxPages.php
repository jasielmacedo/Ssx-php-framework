<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

class SsxAjaxPages extends SsxAjaxElement
{
	
	public $module = "ssxpages";
	
	public $action = "edit";
	
	public function generateslug($data)
	{
		$SsxProtect = new SsxProtect(3600,false,"pages_ajax_verification");
	
		if($SsxProtect->checkTokenByValue($data['token']))
		{
			$SsxPages = new SsxPages();
			
			$slug = Ssx::$utils->generateSlug($data['title']);
			
			$check = $SsxPages->getBySlug($slug);
			
			if($check)
			{
				$key = 1;
				$found = false;
				while(!$found)
				{
					if(!$SsxPages->getBySlug($slug."-".$key))
					{
						$found = true;
					}else{
						$key++;
					}
				}
				
				return array('success'=>true, 'slug'=>$slug."-".$key);
			}
			return array('success'=>true, 'slug'=>$slug);
		}else{
			return array('success'=>false);
		}
	}
}