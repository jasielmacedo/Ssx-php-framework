<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */
 
 $SsxPages = new SsxPages();
 $SsxTags = new SsxTags();
 
 load_css('css/jquery.tagit.css');
 
 load_js('admin.ssxpages.edit.js');
 load_js('core/SsxUpload');
 load_js('core/jquery.form');
 load_js('core/tag-it.min');
 load_js("https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js");

 
 $args = array(
 	'fields'=>array(
 		array('field'=>'title', 'type'=>'text', 'required'=>true,'error'=>'Informe o título da página'),
 		array('field'=>'slug', 'type'=>'text', 'required'=>true,'error'=>'Informe a slug da página'),
 	)
 );
 
 
 $id = Ssx::$request->fromFriendlyUrl(2);
 
 $SsxEditConstruct = new SsxEditConstruct($args);
 $SsxEditor = new SsxEditor();
 
 $SsxProtectAjax = new SsxProtect(3600,false,"pages_ajax_verification");
 $SsxProtectUpload = new SsxProtect(3600,false,"ajax_upload");
 
 $fill_content = "";
 $fill = false;
 if(isset($id) && $id)
 {
 	 $fill = $SsxPages->fill($id,false);
 	 if($fill)
 	 {
 	 	 $fill_content = $fill['content'];
 	 	 $tags = $SsxTags->getAllObjectTags($fill['id'],$SsxPages->table_name);
 	 	 if($tags)
 	 	 {
 	 	 	$tagsList = array();
 	 	 	foreach($tags as $tag){$tagsList[] = $tag['name'];}
 	 	 	$fill['tags'] = implode(',',$tagsList);
 	 	 	$fill['tags_js'] = "'".implode("','",$tagsList)."'";
 	 	 }
 	 	 
 	 	 $medias_videos = SsxConfig::get('page_'.$fill['id'],'serialized');
 	 	 if($medias_videos)
 	 	 {
 	 	 	if(isset($medias_videos['medias']))
 	 	 		$fill['medias'] = $medias_videos['medias'];
 	 	 	
 	 	 	if(isset($medias_videos['videos']))
 	 	 		$fill['videos'] = $medias_videos['videos'];
 	 	 }
 	 }else{
 	 	$id = "";
 	 }
 }
 
 if($SsxEditConstruct->save())
 {
 	$data = array(
 		'id'=>$id,
 		'title'=>Ssx::$request->fromPost('title'),
 		'slug'=>emptyComplete(Ssx::$request->fromPost('slug')),
 		'status'=>emptyComplete(Ssx::$request->fromPost('status'),"0"),
 		'content'=>isset($_POST['ssx_editor']) && $_POST['ssx_editor']?stripslashes($_POST['ssx_editor']):"",
 		'seo_title'=>emptyComplete(Ssx::$request->fromPost('seo_title')),
 		'seo_keywords'=>emptyComplete(Ssx::$request->fromPost('seo_keywords')),
 		'seo_description'=>emptyComplete(Ssx::$request->fromPost('seo_description')),
 		'featured_image'=>emptyComplete(Ssx::$request->fromPost('featured_image')),
 	);
 	
 	
 	$serialize = array();
 	
 	$medias = Ssx::$request->fromPost('medias');
 	if($medias)
 	{
 		foreach($medias as $list)
 		{
 			if($list)
 				$serialize['medias'][] = $list;
 		}
 	}
 	
 	$videos = Ssx::$request->fromPost('videos');
 	
 	if($videos)
 	{
 		foreach($videos as $list)
 		{
 			if($list)
 				$serialize['videos'][] = $list;
 		}
 	}
 	
 	$tags = Ssx::$request->fromPost('tags');

 	if($SsxPages->getBySlug($data['slug']) && !$id)
 	{
 		Ssx::$themes->assign('data_error', "Slug informada já existe");
 		$fill = $data;
 	}else{
 		if($id)
 		{
 			$SsxTags->removeObjectRelation($id, $SsxPages->table_name);
 		}
 		
 		$id = $SsxPages->save($data);
 		
 		if($id)
 		{ 
 			if($tags)
 			{
 				$tagList = explode(',',$tags);
 				foreach($tagList as $tag)
 				{
 					$tag = trim($tag);
 					$tagData = $SsxTags->getTagByName($tag);
 					if(!$tagData)
 						$tag_id = $SsxTags->save(array('name'=>$tag));
 					else 
 						$tag_id = $tagData['id'];
 					$SsxTags->addTagInObject($id, $tag_id, $SsxPages->table_name);
 				}
 			} 	

 			SsxConfig::set('page_'.$id, serialize($serialize));
 			
 			header_redirect(get_url(the_module(),'view/'.$id));
 		}
 	}
 }
 
 $SsxEditor->editor($fill_content);
 
 Ssx::$themes->assign('edit', $fill); 
 Ssx::$themes->assign('ajax_token', $SsxProtectAjax->getFieldValue());
 Ssx::$themes->assign('token_upload', $SsxProtectUpload->getFieldValue());
 Ssx::$themes->assign('fields', $SsxEditConstruct->constructTable());
 Ssx::$themes->assign('js_content', $SsxEditConstruct->constructValidator());
 