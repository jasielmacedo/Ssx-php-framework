<?php
/**
 * 
 * Adaptação de uma classe criada em 2006 por Felipe Lucio da Silva 
 * @adaptation Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.1
 * 
 * Acrescentado funções de Gregory Brown ( colordecode, scaleInto,transformToFit )
 */

defined("SSX") or die;

class SsxImage
{
    public $name;
    public $x;
    public $y;
    public $mime;
    public $path;
    public $resource;

    // Construtor, recebe argumento com o path/nome da img a ser aberta
    public function __construct($path)
    {
        if(is_file($path))
        {
            $temp       = @getimagesize($path);
            $this->mime = $temp['2'];
            $this->x    = $temp['0'];
            $this->y    = $temp['1'];
            
            // Separa o path do nome da imagem
            $this->path = explode('/',$path);
            $this->name = array_pop($this->path);
            $this->path = implode('/',$this->path);
            $this->path .= "/";

            // Abre o resource já na inicialização do Objeto
            $this->open();
        }
    }

    // Abre o resource da imagem "dinamicamente" (ou quase isso) =P
    public function open()
    {
        if(is_file($this->path.$this->name))
        {
            switch($this->mime)
            {
                case 1:
                    $this->resource = imagecreatefromgif($this->path.$this->name);
                    break;
                case 2:
                    $this->resource = imagecreatefromjpeg($this->path.$this->name);
                    break;
                case 3:
                    $this->resource = imagecreatefrompng($this->path.$this->name);
                    break;
                case 6:
                    $this->resource = imagecreatefromwbmp($this->path.$this->name);
                    break;
                default:
                    $this->resource = false;
                    break;
            }
        }


    }

    // Metodo para "juntar" duas imagens, os argumentos sao
    // $sImg - outro objeto da classe Image
    // $dX e $dY - posicao x e y onde a segunda imagem vai sobrepor a original
    // $alpha - transparencia: 0 - transparente, 100 simplesmente copia
    // $sX e $sY - Serve para pegar somente uma parteda img original
    // $sW e $sH - Altura e Largura do "box" de sobreposicao
    public function merge(Image $sImg,$dX=0,$dY=0,$alpha=100,$sX=0,$sY=0,$sW=FALSE,$sH=FALSE)
    {
        if(!$sW)
    {
            $sW = $sImg->x;
        }

        if(!$sH)
        {
            $sH = $sImg->y;
    }

        imagealphablending($sImg->resource,TRUE);
        imagecopymerge($this->resource,$sImg->resource,$dX,$dY,
            $sX,$sY,$sW,$sH,$alpha);
        imagealphablending($sImg->resource,FALSE);
    }

    // Metodo para Redimensionar a img, e so colocar o novo tamanho de x e y
    public function resize($newX,$newY)
    {
        if($this->resource)
        {
            $newImg = imagecreatetruecolor($newX,$newY);
            imagecopyresampled($newImg,$this->resource,0,0,0,0,$newX,$newY,$this->x,$this->y);
            $this->resource = $newImg;
            $this->x = $newX;
            $this->y = $newY;
        }
        else
        {
            return false;
        }
    }
    
    public function moveTo($x, $y)
    {
    	if($this->resource)
        {
            $newImg = imagecreatetruecolor($this->x,$this->y);
            imagecopyresampled($newImg,$this->resource,$x,$y,0,0,$this->x,$this->y,$this->x,$this->y);
            $this->resource = $newImg;
            $this->x = $newX;
            $this->y = $newY;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Redimenciona a imagem sempre no centro
     * 
     * @param int $newX
     * @param int $nexY
     */
    public function fitCenter($newX, $newY, $padding_top=false, $padding_left=false)
    {
    	
    	$prop_new = $newX / $newY;
    	$prop_anterior = $this->x / $this->y;
    	
    	 if($prop_new > $prop_anterior)
     	 {
			 $newWidth = $newX;
			 $newHeigth = $newWidth / $prop_anterior;
     	 }else
     	 {
     		 $newHeigth = $newY;
     		 $newWidth = $newHeigth * $prop_anterior;
     	 }
     	 
     	 if($padding_left === false)
     	 	$padding_left = Math::Round(($newX/2) - ($newWidth/2));
     	 	
     	 if($padding_top === false)
     	 	$padding_top =  Math::Round(($newY/2) - ($newHeigth/2));
     	 
     	 
     	 $newImg = imagecreatetruecolor($newWidth,$newHeigth);
     	 imagecopyresampled($newImg,$this->resource,0,0,0,0,$newWidth,$newHeigth,$this->x,$this->y);
     	 
     	 $newImgFinal = imagecreatetruecolor($newX,$newY);
     	 imagecopyresampled($newImgFinal,$newImg,$padding_left,$padding_top,0,0,$newWidth,$newHeigth,$newWidth,$newHeigth);
     	 
     	 
     	 $this->resource = $newImgFinal;
         $this->x = $newX;
         $this->y = $newY;
         
         return array('top'=>$padding_top, 'left'=>$padding_left);
    }
    
    // decode color    
	private function colordecode($hex){ 
        $code[r] = hexdec(substr($hex, 0 ,2)); 
        $code[g] = hexdec(substr($hex, 2 ,2)); 
        $code[b] = hexdec(substr($hex, 4 ,2)); 
        return $code; 
    }
    
    // scale the image constraining proportions (maxX and maxY) 
    public function transformToFit($newX,$newY)
    { 
        $x= $this->x; 
        $y= $this->y; 
        
        $mlt=$newX/$x; 
        
        $nx=ceil($x * $mlt); 
        $ny=ceil($y * $mlt); 
         
        if ($ny > $newY)
        { 
            $mlt=$newY/$ny; 
            $nx=ceil($nx * $mlt); 
            $ny=ceil($ny * $mlt); 
        } 
         
        $this->resize($nx,$ny); 
    }
    
    public function scaleInto($newX,$newY,$bgColor="FFFFFF")
    {
    	$backgroundimage = imagecreatetruecolor($newX,$newY); 
        $code = $this->colordecode($bgColor); 
        $backgroundcolor = ImageColorAllocate($backgroundimage, $code[r], $code[g], $code[b]); 
        ImageFilledRectangle($backgroundimage, 0, 0, $newX, $newY, $backgroundcolor); 
        $x = $this->x; 
        $y = $this->y; 
         
        ImageAlphaBlending($backgroundimage, true); 
        
        $this->transformToFit($newX,$newY); 
         
        $x = $this->x+1; 
        $y = $this->y+1; 
        $sX = ceil(($newX-$x)/2); 
        $sY = ceil(($newY-$y)/2); 
         
        imagecopy($backgroundimage, $this->resource, $sX, $sY, 0, 0, $newX+4, $newY+4); 
        // fix right side 
        ImageFilledRectangle($backgroundimage, ($newX-$sX-1), 0, $newX, $newY, $backgroundcolor); 
         
        // fix bottom side 
        ImageFilledRectangle($backgroundimage, 0, ($newY-$sY-1), $newX, $newY, $backgroundcolor); 
         
        $this->resource = $backgroundimage; 
        $this->x = $newX;
        $this->y = $newY;
    }
    
    public function propWidth($newX)
    {
    	$propHeight = $this->y * $newX / $this->x;
    	$this->resize($newX, $propHeight);
    }

    // Metodo para salvar as alteracoes feitas na imagem, se não passar argumentos
    // ele simplesmente sobrepoe o arquivo original
    public function save($name='')
    {
        // Limpa a string
        $name = trim($name);
        // se nao foi passado argumento a classe pega os dados da imagem original
        if($name=='')
        {
            $name = $this->path.$this->name;
        }
        // Pega o formato de acordo com a extensao do nome passado como argumento
        $format = strtolower(substr($name,-3,3));
        switch($format)
        {
            case 'gif':
                imagegif($this->resource,$name,80);
                break;
            case 'peg':
            case 'jpg':
                imagejpeg($this->resource,$name,80);
                break;
            case 'png':
                imagepng($this->resource,$name,8);
                break;
            case 'bmp':
                imagewbmp($this->resource,$name,80);
                break;
            default:
                return false;
                break;
        }
    }

}

?>
