<?php
/**
 * 
 * Usa o editor js tinymce como base para manipular o editor
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @uses tinymce
 */

/**
 * 
 * Implementação simples
 * não há formas de customizar o tinymce ainda
 *
 */
class SsxEditor
{
	public $editor_uri;
	
	public $editor_url;

	public $type = "full";
	
	public $value;
	
	public $required = false;
	
	public function SsxEditor()
	{
		$this->editor_uri = PROJECTLOWPATH . "resources/tinymce/tinymce.min.js";

		$this->editor_url = projecturl() . "resources/tinymce/tinymce.min.js";

		if(!file_exists($this->editor_uri))
			die("SsxEditor: Editor tinymce não encontrado");
			
	}
	
	public function editor($content="", $required=false)
	{
		$this->value = $content;
		$this->required = (bool)$required;
		
		SsxActivity::addListener(SsxActivity::SSX_HEAD, array($this, 'addDependences'));
	}
	
	public function setValue($content)
	{
		$this->value = $content;
	}
	
	private function typingEditor()
	{
		switch($this->type)
		{
			case "full":
			default:
				load_js("core/tiny_mce_full");
			break;
		}
	}
	
	public function drawEditor($fieldName="ssx_editor", $fieldValue="")
	{
		
		$this->typingEditor();
		load_js($this->editor_url);
		return "<textarea width='100%' height='450' name='".$fieldName."' id='ssx_editor'>".$fieldValue."</textarea>";
	}
	
	public function addDependences()
	{
		
		$this->typingEditor();
		load_js($this->editor_url);
		
		Ssx::$themes->assign('ssx_editor', " <span class='label label-danger' id='ssx_editor_error'></span><textarea width='100%' height='450' name='ssx_editor' id='ssx_editor' ".($this->required?'class="required" data-error="#ssx_editor_error"':'').">".$this->value."</textarea>");
	}
}
