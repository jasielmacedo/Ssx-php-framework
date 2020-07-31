<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 *<entry>
    <published>2014-04-19T14:00:01-04:00</published>
    <updated>2014-04-19T14:00:01-04:00</updated>
    <title></title>
    <content type="html"></content>
    <link type="text/html" rel="alternate" href="http://www.polygon.com/2014/4/19/5631374/tales-of-hearts-r-west-localization-north-america"/>
    <id></id>
    <author>
      <name></name>
    </author>
  </entry>
 */

defined("SSX") or die;

class SsxFeedItem
{
	private $title;
	private $description;
	private $pubDate;
	private $link;
	private $author;
	
	/**
	 * Cria um elemento para ser adicionado no feed
	 * 
	 * @param $title string titulo do Item
	 * @param $description string Texto descritivo de no maximo 160 linhas
	 * @param $pubDate DATETIME exatamente no formato do Banco de Dados
	 * @param $link string url para o item
	 */
	public function __construct($title, $description, $pubDate, $link,$author)
	{
		$this->title = $title;
		$this->description = $description;
		$this->pubDate = $pubDate;
		$this->link = $link;
		$this->author = $author;
	}
	
	/**
	 * 
	 * @return string | Retorna a forma escrita desse elemento para ser enviado para a tela
	 */
	public function ToString()
	{
		$date = date("D, d M Y H:i:s O", strtotime($this->pubDate));
		$content = "<entry>\n";
		$content .= " <published>".$date."</published>\n";
		$content .= " <updated>".$date."</updated>\n";
		$content .= " <title>".$this->title."</title>\n";
		$content .= " <link type=\"text/html\" rel=\"alternate\" href=\"".$this->link."\" />\n";
		$content .= " <id>".$this->link."</id>";
		$content .= " <content type=\"html\">".$this->description."</content>";
		$content .= " <author>";
		$content .= " 	<name>".$this->author."</name>";
		$content .= " </author>";
		$content .= "</entry>\n";
		
		return $content;
	}
} 