<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */


class SsxAjaxUpload extends SsxAjaxElement
{	
	public function uploadFile()
	{
		$SsxProtect = new SsxProtect(3600,false,"ajax_upload");
		
		$token = Ssx::$request->fromPost('token');
		
		if($SsxProtect->checkTokenByValue($token))
		{
			$imageData = Ssx::$request->files->get('ssx_upload_item');
			
			$SsxUpload = new SsxUpload(PROJECTLOWPATH . 'upload/images',false);	
			$fileName = $SsxUpload->uploadImage($imageData);
			
			$width = Ssx::$request->fromPost('item_width');
			$height = Ssx::$request->fromPost('item_height');
			
			if($fileName)
			{	
				if($width)
				{
					$SsxImage = new SsxImage(PROJECTLOWPATH . 'upload/images/' . $fileName);
					
					if($height)
					{
						$SsxImage->fitCenter($width, $height);
						$SsxImage->save();
					}else{
						$SsxImage->propWidth($width);
						$SsxImage->save();
					}
				}
				
				return array(
					'success'=>true,
					'clean_file_url'=> "upload/images/" .$fileName,
					'file_url'=> projecturl(). "upload/images/" .$fileName
				);
			}
		}
		
		return array('success'=>false);
	}
}