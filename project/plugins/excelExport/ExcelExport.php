<?php
/**
 * Classe de export de arquivo Excel
 * 
 * @author Gregory Brown <bugzbrown@gmail.com>
 * @adapted_by Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @since 19/01/2015
 * @package ExcelExport
 * @uses ExcelExport
 * @example $var = Ssx::$plugins->load('ExcelExport'); 
 * $var->exportData($obj);
 */
class ExcelExport
{
	/**
	 * Limpa as strings para exibir no excel
	 * @param String $str - linha que precisa ser limpa para exibir no excel
	 * @return void
	 */
	public function cleanData(&$str)
	{
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if (strstr($str, '"'))
			$str = '"' . str_replace('"', '""', $str) . '"';
	}
	
	/**
	 * Arruma o nome do arquivo
	 * @param nome_do_arquivo $str
	 * @return String
	 */
	public function fileClear($str)
	{
		return Ssx::$utils->generateSlug($str,50);
	}
	
	/**
	 *
	 * @param array $obj objeto de configuração
	 * $obj['file_prefix']="export_"
	 * $obj['show_date']=true
	 * $obj['show_time']=true
	 * $obj['data'] = $array_with_data
	 * $obj['debug'] = false
	 */
	public function exportData($obj)
	{
		$objData    = isset($obj['data'])?$obj['data']:null;
		$objPrefix  = isset($obj['file_prefix'])?$obj['file_prefix']:'export';
		$objDate    = isset($obj['show_date'])?$obj['show_date']:true;
		$objTime    = isset($obj['show_time'])?$obj['show_time']:true;
		$objDebug   = isset($obj['debug'])?$obj['debug']:false;
	
		if (!$objData) return false;
	
		return $this->prepareData($objData, $objPrefix, $objDate, $objTime, $objDebug);
	
	}
	
	/**
	 * Função que faz o export para excel
	 * @param array $objData - objeto array que tem todos os dados que serão exportados.
	 * @param String $objPrefix - prefixo do arquivo - default é "export"
	 * @param boolean $objDate - se TRUE (padrão) exibe a data no nome do arquivo
	 * @param boolean $objTime - se TRUE (padrão) exibe a hora no nome do arquivo
	 * @param boolean $debug - se TRUE (padrão false)- não dispara download - faz dump na tela
	 * @return type
	 */
	private function prepareData($objData, $objPrefix="export",$objDate=true,$objTime=true,$debug=false) 
	{
		// filename for download
		$dt = ($objDate?'Ymd':'').($objTime?'Hjs':'');
		$filename = $this->cleanData($objPrefix) . (($dt=='')?'':'-'.date($dt)) . ".xls";
	
		if (!$debug){
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: application/vnd.ms-excel");
		}
	
		$flag = false;
		foreach ($objData as $row) 
		{
			if (!$flag) 
			{
				// display field/column names as first row
				echo implode("\t", array_keys($row)) . "\r\n";
				$flag = true;
			}
			array_walk($row, array($this,'cleanData'));
			echo implode("\t", array_values($row)) . "\r\n";
		}
		return !$debug;
	}	
}