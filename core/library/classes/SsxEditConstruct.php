<?php
/**
 * Classe de contrução de forms para o admin usando um modelo padrão de construção por table
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

defined("SSX") or die;

class SsxEditConstruct
{
	private $args;
	
	private $fields;
	
	private $method = "post";
	
	private $action = "";
	
	private $editor = false;
	
	
	/**
	 * Objeto do plugin ckeditor
	 * @var SsxEditor
	 */
	private $editor_plugin;
	
	/**
	 * 
	 * Classe de protecao contra Cross-Site Request Forgery
	 * @var SsxProtect
	 */
	private $ssx_protect;
	
	/**
	 * 
	 * Habilita a proteção
	 * @var bool
	 */
	private $active_protect = false;
	
	public function SsxEditConstruct($args, $protect = false)
	{
		if(!is_array($args))
			die(SSX_EDIT_CONSTRUCT_ERROR_00);
			
		$this->args = $args;
		$this->active_protect = $protect;
		
		// o usuario tem 15 minutos para completar a solicitacao
		if($protect)
			$this->ssx_protect = new SsxProtect(3600,false,"edit_construct_".the_module()."_".the_action());
		
		$this->prepare();
		
		load_js("jquery-maskedinput-min.js");
		
	}
	
	private function prepare()
	{		
		if($this->args)
		{
			if(isset($this->args['fields']) && $this->args['fields'])
			{
				$kReserv = 1;
				foreach($this->args['fields'] as $fields)
				{
					if(isset($fields['field']) && $fields['field'])
					{
						$this->fields[$fields['field']] = array(
							'label'=>isset($fields['label']) && $fields['label']?$fields['label']:"Campo ".$kReserv.":",
							'error'=>isset($fields['error']) && $fields['error']?$fields['error']:"Preencha o campo corretamente",
							'type'=>isset($fields['type']) && $fields['type']?$fields['type']:"text",
							'required'=>isset($fields['required']) && $fields['required']?$fields['required']:false,
							'compare'=>isset($fields['compare']) && $fields['compare']?$fields['compare']:false,
							'value'=>isset($fields['value']) && $fields['value']?$fields['value']:"",
							'options'=>isset($fields['options']) && $fields['options']?$fields['options']:false,
							'model'=>isset($fields['model']) && $fields['model']?$fields['model']:"text",
							'length'=>isset($fields['length']) && $fields['length']?$fields['length']:false,
							'mask'=>isset($fields['mask']) && $fields['mask']?$fields['mask']:false,
						);
						
						if($this->fields[$fields['field']]['type'] == "email")
						{
							$this->fields[$fields['field']]['email_error'] = isset($fields['email_error']) && $fields['email_error']?$fields['email_error']:"Email inv&aacute;lido";
						}
					}
					$kReserv++;
				}
			}
			
			if(isset($this->args['editor']) && $this->args['editor'])
			{
				$this->editor = true;
				$this->editor_plugin = new SsxEditor();
			} 
		}
	}
	
	public function save()
	{
		return Ssx::$request->fromPost('saveValues');
	}
	
	public function setFieldsValue($args)
	{
		if(!is_array($args) || !$this->fields)
			return;
			
		if($args)
		{
			foreach($args as $fieldKey => $fieldValue)
			{
				if(isset($this->fields[$fieldKey]) && $this->fields[$fieldKey])
				{
					$this->fields[$fieldKey]['value'] = $fieldValue;
				}
			}
		}
	}
	
	public function ocultFields($args)
	{
		if(!$this->fields)
			return;
			
		if($args)
		{
			foreach($args as $fieldKey)
			{
				if(isset($this->fields[$fieldKey]) && $this->fields[$fieldKey])
				{
					$this->fields[$fieldKey]['hidden'] = true;
				}
			}
		}
	}
	
	public function constructTable($secureToken=false)
	{
		if(!is_array($this->fields))
			return false;
			
		$content = "<div class='overflow'><hr /><div class='col-lg-4 col-md-4 col-sm-6 col-xs-12'>\n<form autocomplete='off' class='form' action='".$this->action."' method='".$this->method."' enctype=\"multipart/form-data\">\n";
		
		if($this->fields)
		{
			$hidden = "";
			foreach($this->fields as $fieldName => $fieldArgs)
			{
				if(isset($fieldArgs['hidden']) && $fieldArgs['hidden'])
					continue;
				
				if($fieldArgs['type'] != "hidden")
				{
					$content .= "<div class='control-group'>\n";
					$required = (isset($fieldArgs['required']) && $fieldArgs['required'])?"required":"";
					$model = (isset($fieldArgs['model']) && $fieldArgs['model'])?$fieldArgs['model']:"text";
					$length = (isset($fieldArgs['length']) && $fieldArgs['length'])?" data-min='".$fieldArgs['length']."' ":"";
					$mask = (isset($fieldArgs['mask']) && $fieldArgs['mask'])?" data-mask='".$fieldArgs['mask']."' ":"";
					$compare = "";
					if($fieldArgs['compare'] && isset($this->fields[$fieldArgs['compare']]))
					{
						$compare = "data-compare='#field_".$fieldArgs['compare']."'";
					}
					
					if($fieldArgs['type'] != "ckeditor")
						$content .= "<span class='label label-danger' id='field_".$fieldName."_error'></span>\n";
					
					switch($fieldArgs['type'])
					{
						case "label":
							$content .= "<h4>".$fieldArgs['label']."</h4>\n";
						break;
						case "file":
							if($fieldArgs['value'])
								$content .= "<img class='img-polaroid' src='".$fieldArgs['value']."' width='210' /><br />";
							$content .= "<input type='file' class='form-control margin_b_10 ".$required."' name='".$fieldName."' id='field_".$fieldName."' data-error='#field_".$fieldName."_error' />\n";	
						break;
						case "password":
							$content .= "<input type='password' class='form-control margin_b_10 ".$required."' name='".$fieldName."' id='field_".$fieldName."' value='".$fieldArgs['value']."' placeholder='".$fieldArgs['label']."' data-type='pass' ".$length." ".$compare." data-error='#field_".$fieldName."_error' />\n";
						break;
						case "textarea":
							$content .= "<div class='margin_t_10'><span class=''>".$fieldArgs['label']."</span><br/>";
							$content .= "<textarea cols='40' class='form-control ".$required."' rows='5' name='".$fieldName."' id='field_".$fieldName."' data-error='#field_".$fieldName."_error'>".$fieldArgs['value']."</textarea></div>";
						break;
						case "editor":
							if($this->editor)
							{
								$content .= "<div>";
								$content .= $this->editor_plugin->drawEditor($fieldName,$fieldArgs['value']);
								$content .= "</div>";
							}
						break;
						case "select":
							if(isset($fieldArgs['options']) && $fieldArgs['options'] && is_array($fieldArgs['options']))
							{
								$content .= "<select name='".$fieldName."' id='field_".$fieldName."' class='form-control margin_b_10 ".$required."' data-error='#field_".$fieldName."_error'>";
								$content .= "<option value=''>-- Selecione ".$fieldArgs['label']."</option>";
								foreach($fieldArgs['options'] as $selectValue => $selectLabel)
								{
									$content .= "<option value='".$selectValue."' ";
									if($selectValue == $fieldArgs['value'])
									{
										$content .= " selected='selected' ";
									}
									$content .= ">".$selectLabel."</option>";
								}
								$content .= "</select>";
							}
						break;
						case "check":
							if(isset($fieldArgs['options']) && $fieldArgs['options'] && is_array($fieldArgs['options']))
							{
								$content .= "<label class='checkbox'>";
								foreach($fieldArgs['options'] as $selectValue => $selectLabel)
								{
									$content .= " <input type='checkbox' value='".$selectValue."' name='".$fieldName."' ";
									if($selectValue == $fieldArgs['value'])
									{
										$content .= " checked='checked' ";
									}
									$content .= " /> ".$selectLabel." ";
								}
								$content .= $fieldArgs['label']."</label>";								
							}
						break;
						case "text":
						case "email":
						default:
							$content .= "<input type='text' name='".$fieldName."' class='form-control margin_b_10 ".$required." ".(($mask)?'mask':"")."' id='field_".$fieldName."' value='".$fieldArgs['value']."' placeholder='".$fieldArgs['label']."' data-type='".$model."' ".$length." ".$mask." data-error='#field_".$fieldName."_error' />\n";	
						break;
					}	
					
						
					$content .= "</div>\n";
				}else{
					$hidden .= "<input type='hidden' name='".$fieldName."' value='".$fieldArgs['value']."' />";
				}
			}
		}
		
		$content .= "<input type='hidden' name='saveValues' value='trigger' />
						  <button type='submit' class='btn btn-primary margin_t_20'> Salvar</button>
						  ".$hidden."
		";
		
		if($this->active_protect)
		{
			$content .= $this->ssx_protect->getField();
		}
		
		$content .= "</form></div></div>";
		
		return $content;
	}
	
	public function getDataRequest()
	{
		if(!$this->fields)
			return false;
			
		if($this->active_protect)
		{
			if(!$this->ssx_protect->checkToken())
				return false;
		}	
			
		$data_request = array();
		
		if($this->fields)
		{
			foreach($this->fields as $fieldKey => $fieldArgs)
			{
				
				if(isset($fieldArgs['hidden']) && $fieldArgs['hidden'])
					continue;
				

				switch($fieldArgs['type'])
				{
					case "text":
					case "hidden":
					case "password":
					case "textarea":
					case "email":
					case "editor":
					case "select":
						$varTmp = Ssx::$request->fromPost($fieldKey);
						$varTmp = str_replace('\r', '', $varTmp);
						$varTmp = str_replace('\n', '', $varTmp);
						$data_request[$fieldKey] = emptyComplete($varTmp);
					break;
					case "check":
						$varTmp = Ssx::$request->fromPost($fieldKey);
						$data_request[$fieldKey] = ($varTmp === false || empty($varTmp))?false:$varTmp;
					break;
					case "file":
						$data_request[$fieldKey] = Ssx::$request->fromFiles($fieldKey);
					break;
				}	
			}
		}
		
		return $data_request;
	}
	
	public function constructValidator()
	{
		if(!is_array($this->fields))
			return false;
			
		
		$content_jquery = "
				
				jQuery(document).ready(function ($) {
				
				    $('.mask').each(function(){
						$(this).mask($(this).attr('data-mask'));
					});
				
					$('.form').submit(function(){

						if(Ssx.validate(this))
							return true;
						return false;
				
					});
				});
				
				";
		
		return $content_jquery;
	}
}
