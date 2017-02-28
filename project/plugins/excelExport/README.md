# Excel Export #
## Plugin para export de objetos em formato excel.##

###Como utilizar o Plugin

Ative o Plugin no seu site, e siga as instruções abaixo.

### Configurando o plugin ###

O plugin espera receber um array de configuração com os seguintes parâmetros:

 * **$obj['data'] = $array_with_data**
 * $obj['file_prefix']="export_"
 * $obj['show_date']=true
 * $obj['show_time']=true
 * $obj['debug'] = false

### Os Parâmetros ###
---

 **$obj['data'] = $array_with_data**

 Este é o único parâmetro obrigatório do plugin. É nele que você vai colocar todos os dados que você quer exportar para excel em um array assosciativo.
 Seu array deve ter uma estrutura similar a esta:

```
 linha[0][
 	[coluna 1] -> valor 
 	[coluna 2] -> valor 
 	[coluna 3] -> valor 
 ] 
 ...
 linha[2000][
 	[coluna 1] -> valor 
 	[coluna 2] -> valor 
 	[coluna 3] -> valor 
 ] 

```
---

 **$obj['file_prefix']="export"**

Nome do prefixo do arquivo que você quer exportar - se não setado, ele usa "export" como padrão.

---

 **$obj['show_date']=true**

 Se deixado como padrão, ele utiliza a data no formato YYYYMMDD (20130621) e anexa isso ao final do nome do arquivo.

---

 **$obj['show_time']=true**

Se deixado como padrão, ele utiliza a horário no formato HHMMSS (234545) e anexa isso ao final do nome do arquivo.

---

 **$obj['debug'] = false**

Se deixado como padrão, ele não interage no sistema - caso esteja setado como **true**, ele evita o download do arquivo e faz o dump da informação na tela. Útil se você está tendo problemas com algum dado no seu export. 

---

### CONFIGURANDO O PLUGIN ###

Para configura-lo, basta passar um array para o plugin
```
#!php

$params = array(
	'data' => $fetchedData,
	'show_time' => false,
	'file_prefix' => 'sample file data'
);

```

Presupondo que o **$fetchedData** fosse um array válido, o arquivo salvo teria um nome parecido com este:

**sample-file-data-20150114.xls**

---- 

A maneira mais correta de utilizar o plugin é verificar se o mesmo se encontra ativo.

Na sua View - coloque o seguinte código:

```
#!php

// define os parâmetros do plugin
$params = array(
	'data' => $fetchedData,
	'file_prefix' => 'my export'
);

// verifica se o plugin está de fato rodando no site
if(defined('EXCEL_EXPORT') && EXCEL_EXPORT){
	// dispara o plugin - o retorno não é necessário já que ele intercepta o header e dispara um download.
	// porem, você pode querer tratar alguma condição em caso de erros.
    $retorno=SsxActivity::dispatchActivity('excel_export',$params);
}else{
	// Usa um campo default no layout para exibir erro.
    Ssx::$themes->assign(ERR_MSG, 'No Plugin Found');
}
```


