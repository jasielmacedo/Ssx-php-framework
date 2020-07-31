<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

class SsxTags extends SsxModels
{
	
	public $table_name = "ssx_tags";
	
	public $fields = array(
		'id'=>'string',
		'project_id'=>'int',
		'created_by'=>'string',
		'date_created'=>'datetime',
		'modified_by'=>'string',
		'date_modified'=>'datetime',
		'name'=>'string'
	);
	
	
	public function __construct()
	{
		parent::super();
	}
	
	public function save($data)
	{
		return parent::saveValues($data);
	}
	
	public function getTagByName($name)
	{
		return parent::filterData(array('name'=>$name,'project_id'=>Ssx::$project),true);
	}
	
	public function delete($tag_id)
	{
		$this->removeTagRelation($tag_id);
		$this->delete(array('id'=>$tag_id));
	}
	
	public function addTagInObject($object_id, $tag_id, $object_table)
	{
		$old = $this->fields;
		$old_table = $this->table_name;
		$old_primary = $this->primary_key;
	
		$this->table_name = "ssx_tags_object";
		$this->primary_key = "tag_id";
		$this->fields = array('tag_id'=>'string','object_id'=>'string','object_table'=>'string');
	
		$result = parent::saveValues(array(
				'tag_id'=>$tag_id,
				'object_id'=>$object_id,
				'object_table'=>$object_table
		),false,false);
	
		$this->table_name = $old_table;
		$this->primary_key = $old_primary;
		$this->fields = $old;
	
		return $result;
	}
	
	public function checkTagInObject($object_table, $object_id, $tag_id)
	{
		$old_table = $this->table_name;
		$old = $this->fields;
	
		$this->table_name = "ssx_tags_object";
		$this->fields = array('tag_id'=>'string','object_id'=>'string','object_table'=>'string');
	
		$result =  parent::filterData(array('tag_id'=>$tag_id,'object_id'=>$object_id, 'object_table'=>$object_table),true);
	
		$this->table_name = $old_table;
		$this->fields = $old;
	
		return $result;
	}
	
	public function removeTagInObject($object_table, $object_id, $tag_id)
	{
		$old_table = $this->table_name;
		$old = $this->fields;
	
		$this->table_name = "ssx_tags_object";
		$this->fields = array('tag_id'=>'string','object_id'=>'string','object_table'=>'string');
	
		parent::delete(array('tag_id'=>$tag_id,'object_id'=>$object_id,'object_table'=>$object_table));
	
		$this->table_name = $old_table;
		$this->fields = $old;
	}
	
	public function removeTagRelation($tag_id)
	{
		$old_table = $this->table_name;
		$old = $this->fields;
	
		$this->table_name = "ssx_tags_object";
		$this->fields = array('tag_id'=>'string','object_id'=>'string','object_table'=>'string');
	
		parent::delete(array('tag_id'=>$tag_id));
	
		$this->table_name = $old_table;
		$this->fields = $old;
	}
	
	public function removeObjectRelation($object_id, $object_table)
	{
		$old_table = $this->table_name;
		$old = $this->fields;
	
		$this->table_name = "ssx_tags_object";
		$this->fields = array('tag_id'=>'string','object_id'=>'string','object_table'=>'string');
	
		parent::delete(array('object_id'=>$object_id,'object_table'=>$object_table));
	
		$this->table_name = $old_table;
		$this->fields = $old;
	}
	
	public function getAllObjectTags($object_id, $object_table)
	{
		$old_table = $this->table_name;
		$old = $this->fields;
		
		$this->table_name = "ssx_tags_object";
		$this->fields = array('tag_id'=>'string','object_id'=>'string','object_table'=>'string');
		
		
		$args = array(
				'fields'=>array($this->prefix =>$this->field_array()),
				'AND'=>array(
						array('field'=>$this->prefix.'.object_id','compare'=>'=','value'=>$object_id),
						array('field'=>$this->prefix.'.object_table','compare'=>'=','value'=>$object_table)
				)
		);
		
		$args['JOIN']['type'] = "inner";
		$args['JOIN']['conditions'][] = array('prefix'=>'ST','table'=>'ssx_tags','field'=>array('id'=>array($this->prefix =>'tag_id')));
		$args['fields']['ST'] = array('`name`');
		
		$args['ORDER'] = "ST.name ASC";
		
		$result = parent::getDatabyField($args,false);
		
		$this->table_name = $old_table;
		$this->fields = $old;
		
		return $result;
	}
	
	public function getAllObjectsInTag($tag_id, $object_table)
	{
		$old_table = $this->table_name;
		$old = $this->fields;
		
		$this->table_name = "ssx_tags_object";
		$this->fields = array('tag_id'=>'string','object_id'=>'string','object_table'=>'string');
		
		
		$args = array(
				'fields'=>array($this->prefix =>$this->field_array()),
				'AND'=>array(
						array('field'=>$this->prefix.'.tag_id','compare'=>'=','value'=>$tag_id),
						array('field'=>$this->prefix.'.object_table','compare'=>'=','value'=>$object_table)
				)
		);
		
		$args['JOIN']['type'] = "inner";
		$args['JOIN']['conditions'][] = array('prefix'=>'ST','table'=>'ssx_tags','field'=>array('id'=>array($this->prefix =>'tag_id')));
		$args['fields']['ST'] = array('`name`');
		
		$args['ORDER'] = "ST.name ASC";
		
		$result = parent::getDatabyField($args,false);
		
		$this->table_name = $old_table;
		$this->fields = $old;
		
		return $result;
	}
}