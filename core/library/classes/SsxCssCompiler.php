<?php
/**
 * 
 * @author Eduardo Kraus 
 * @link http://php.eduardokraus.com/eu-vs-cache-ganhei-a-batalha
 * @implementation Jasiel Macedo 
 * 
 */
class SsxCssCompiler
{
	private $css = array();

	private $filemtime = 0;
	private $file      = '';

	public function addCss( $cssName )
	{
		$this->css[] = $cssName;
		$this->filemtime += filemtime($cssName);
	}

	public function linkCss()
	{
		$css_file = 'c_css_' . md5( $this->filemtime ) . '.css';
		
		$this->file = Ssx::$themes->ssx_theme_path.'/'.$css_file;

		if( !file_exists( $this->file ))
		{
			$handle = @scandir(Ssx::$themes->ssx_theme_path);
			if($handle)
			{		
				unset($handle[0]);
				unset($handle[1]);
				
				if(count($handle)>1)
				{
					foreach($handle as $row)
					{
						if(!is_dir(Ssx::$themes->ssx_theme_path . "/" . $row))
						{
							if(substr($row,0,6) == "c_css_")
							{
								@unlink(Ssx::$themes->ssx_theme_path . "/" . $row);
							}
						}
					}
				}
			}			
			$this->createCssFile();
		}

		return $css_file;
	}

	private function createCssFile()
	{
		$salvaCSS = '';

		foreach ( $this->css as $css )
		{
			if(file_exists($css))
			{
				$salvaCSS .= @file_get_contents( $css );
			}
		}

		$salvaCSS = preg_replace('!/\*.*?\*/!s', ' ', $salvaCSS);
		$salvaCSS = preg_replace('/\s+/', '', $salvaCSS);

		// Salva
		@file_put_contents( $this->file, $salvaCSS );
	}
}