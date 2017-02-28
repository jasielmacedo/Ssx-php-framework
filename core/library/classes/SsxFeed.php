<?php
/**
 * Classe de controle de Feed do Ssx
 * É possível adicionar no feed os elementos
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 *
<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="en">
  <title>Polygon -  All</title>
  <subtitle></subtitle>
  <icon>http://cdn1.vox-cdn.com/community_logos/42931/favicon.ico</icon>
  <updated>2014-04-20T14:00:28-04:00</updated>
  <id>http://www.polygon.com/rss/index.xml</id>
  <link type="text/html" rel="alternate" href="http://www.polygon.com/"/>
 */

defined("SSX") or die;

class SsxFeed
{
	
	private $rss_title;
	
	private $rss_description;
	
	private $rss_link;
	
	private $rss_items;
	
	private $rss_icon;
	
	private $rss_updated;
	
	private $items;
	
	public function setTitle($title)
	{
		if(!is_string($title))
			return false;

		$this->rss_title = $title;
		$this->items = array();
	}
	
	public function setDescription($description)
	{
		if(!is_string($description))
			return false;
			
		$this->rss_description = $description;
	}
	
	public function setUpdatedDate($update)
	{
		if(!is_string($update))
			return false;
			
		$this->rss_updated = date("D, d M Y H:i:s O", strtotime($update));
	}
	
	public function setFeedItem(SsxFeedItem $item)
	{
		if(!$item)
			return false;
			
		array_push($this->items,$item);
	}
	
	public function setLink($link)
	{
		if(!is_string($link))
			return false;
			
		$this->rss_link = $link;
	}
	
	public function draw()
	{
		$content = "";
		
		$content .= "\n	<title>".$this->rss_title."</title>\n";
		$content .= "	<subtitle>".$this->rss_description."</subtitle>\n";
		$content .= "   <icon>".$this->rss_icon."</icon>";
		$content .= "   <id>".$this->rss_link."</id>";
		$content .= "   <link type=\"text/html\" rel=\"alternate\" href=\"".$this->rss_link."\"/>";
		$content .= "   <updated>".$this->rss_updated."</updated>";
		
		if($this->items && count($this->items)>0)
		{
			foreach($this->items as $listing)
			{
				$content .= $listing->ToString();
			}
		}
		return $content;
	}
	
}