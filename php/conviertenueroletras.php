<?php
	function numerotexto($numero) {
    // Primero tomamos el numero y le quitamos los caracteres especiales y extras
    // Dejando solamente el punto "." que separa los decimales
    // Si encuentra mas de un punto, devuelve error.
    
    $extras= array("/[\$]/","/ /","/,/","/-/");
    $limpio=preg_replace($extras,"",$numero);
    $partes=explode(".",$limpio);
    if (count($partes)>2) {
        return "Error, el n&uacute;mero no es correcto";
        exit();		
    }
    
    // Ahora explotamos la parte del numero en elementos de un array que
    // llamaremos $digitos, y contamos los grupos de tres digitos
    // resultantes
    
    $digitos_piezas=chunk_split ($partes[0],1,"#");
     $digitos_piezas=substr($digitos_piezas,0,strlen($digitos_piezas)-1);
    $digitos=explode("#",$digitos_piezas);
    $todos=count($digitos);
    $grupos=ceil (count($digitos)/3);
    
    // comenzamos a dar formato a cada grupo
    
    $unidad = array    ('un','dos','tres','cuatro','cinco','seis','siete','ocho','nueve');
    $decenas = array ('diez','once','doce', 'trece','catorce','quince');
    $decena = array    ('dieci','veinti','treinta','cuarenta','cincuenta','sesenta','setenta','ochenta','noventa');
    $centena = array    ('ciento','doscientos','trescientos','cuatrocientos','quinientos','seiscientos','setecientos','ochocientos','novecientos');
    $resto=$todos;
    
    for ($i=1; $i<=$grupos; $i++) {
        
        // Hacemos el grupo
        if ($resto>=3) {
            $corte=3; } else {
            $corte=$resto;
        }
            $offset=(($i*3)-3)+$corte;
            $offset=$offset*(-1);
        
        // corremos el codigo posteado por 
        
        $num=implode("",array_slice ($digitos,$offset,$corte));
        $resultado[$i] = "";
        $cen = (int) ($num / 100);              //Cifra de las centenas
        $doble = $num - ($cen*100);             //Cifras de las decenas y unidades
        $dec = (int)($num / 10) - ($cen*10);    //Cifra de laa decenas
        $uni = $num - ($dec*10) - ($cen*100);   //Cifra de las unidades
        if ($cen > 0) {
           if ($num == 100) $resultado[$i] = "cien";
           else $resultado[$i] = $centena[$cen-1].' ';
        }//end if
        if ($doble>0) {
           if ($doble == 20) {
              $resultado[$i] .= " veinte";
           }elseif (($doble < 16) and ($doble>9)) {
              $resultado[$i] .= $decenas[$doble-10];
           }else {
				if($dec==0)
				{}
				else
				{
				$resultado[$i] .=' '. $decena[$dec-1];
				}		   
              
           }//end if
           if ($dec>2 and $uni<>0) $resultado[$i] .=' y ';
           if (($uni>0) and ($doble>15) or ($dec==0)) {
              if ($i==1 && $uni == 1) $resultado[$i].="uno";
              else $resultado[$i].=$unidad[$uni-1];
           }
        }

        // Le agregamos la terminacion del grupo
        switch ($i) {
            case 2:
            $resultado[$i].= ($resultado[$i]=="") ? "" : " mil ";
            break;
            case 3:
            //$resultado[$i].= ($num==1) ? " mill&oacute;n " : " millones ";
			$resultado[$i].= ($num==1) ? " millÓn " : " millones ";
            break;
			
        }
        $resto-=$corte;
    }
    
    // Sacamos el resultado (primero invertimos el array)
    $resultado_inv= array_reverse($resultado, TRUE);
    $final="";
    foreach ($resultado_inv as $parte){
        $final.=$parte;
    }
	$posicion_punto= strrpos($numero,".");	
	if($posicion_punto){
		$dec_2=substr($numero,$posicion_punto + 1 ,2);
	}else {
		$dec_2='00';
	}
	//$posicion_punto=strpos('.',$dec_2);
	if(!$final){ 
		$final='CERO '; 
	}else{ 
		if(strlen($dec_2)==1){$dec_2=$dec_2."0";}; 
		$final = $final." con ".$dec_2."/100  ";
	}
    $final = strtoupper($final);
	
	return $final;
	//return  $posicion_punto;
}

//ESTA FUNCTION Y EL SWITCH SOLO ES PARA EL ITEMGRID.
function LlamaRNumerotextoR2($IdMoneSelect,$Total){	
	include("../conexion.php");
	$Letras='';
	$consulta = $db->prepare('SELECT NomMoneda FROM tipo_moneda WHERE IdTipoMoneda=:IdMoneSelect');
	$consulta->bindParam(':IdMoneSelect',$IdMoneSelect);
	$consulta->execute();
	$NomMoneda=$consulta->fetchAll();
	
	$Letras=numerotexto($Total);
	echo $Letras.=$NomMoneda[0]['NomMoneda'];
	
}

//ESTA FUNCTION Y EL SWITCH SOLO ES PARA EL ITEMGRID.
function LlamaRNumerotexto($IdMoneSelect,$Total){	
	include("../conexion.php");
	$Letras='';
	$consulta = $db->prepare('SELECT NomMoneda FROM tipo_moneda WHERE IdTipoMoneda=:IdMoneSelect');
	$consulta->bindParam(':IdMoneSelect',$IdMoneSelect);
	$consulta->execute();
	$NomMoneda=$consulta->fetchAll();
	
	$Letras=numerotexto($Total);
	$Letras.=$NomMoneda[0]['NomMoneda'];
	echo "<input type='hidden' id='HNumLetraTotal' value='".$Letras."'>"; 
}


switch($_GET['Accion']){
	case "NumLetraConvert":	
		LlamaRNumerotexto($_POST['IdMoneSelect'],$_POST['Total']);
		break;
	case "NumLetraConvertR2":	
		LlamaRNumerotextoR2($_POST['IdMoneSelect'],$_POST['Total']);
		break;
}
?>
