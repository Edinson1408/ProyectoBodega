<?php
session_start();

$orgcodxw  = decryptx($orgcod, 'Greed');  //Codigo de la organizacion
require_once('../Class/ConvierteNroLetras.php');
require_once('../Class/RedondeoDecimales.php');
require_once("Cifrado.php");// Cifrado y Desifrado
include('ControlCx.php');
include('../Class/TipoMoneda.php');
include_once("../Class/ReplaceSpecialChar.php");
include('../Componentes/efac/ModInfoReceptor/xmlFile/NCFunciones.php');
include('../Componentes/efac/ModInfoReceptor/xmlFile/phpqrcode/qrlib.php');

$acceder  = new ReplaceCharSpecial();
$link     = ConectarNuevaDB($serv,$CUser,$CPassword,$CNameDB);
$split    = decryptx($thisId, 'Greed');
$TipoDoc  = $thisTDoc;
$IdDoc    = $split;


switch ($TipoDoc) {
  case '1':
      $tabla = "comprobante_venta";
      $tabla2 = "comprobante_venta_detalle";
      $comprobante = "IdComprobante";
      $campoId = 'IdComprobante';
      break;
  case '3':
      $tabla = "comprobante_venta";
      $comprobante = "IdComprobante";
      $tabla2 = "comprobante_venta_detalle";
      $campoId = 'IdComprobante';
      break;
  case '7':
      $tabla = "notas";
      $comprobante = "IdNota";
      $tabla2 = "notas_detalle";
      $campoId = 'IdNota';
      break;
  case '8':
      $tabla = "notas";
      $comprobante = "IdNota";
      $tabla2 = "notas_detalle";
      $campoId = 'IdNota';
      break;
}

$sql = "select ".$tabla.".*,(SELECT NomMoneda FROM tipo_moneda WHERE IdTipoMoneda=".$tabla.".IdTipoMoneda) NomMoneda,e.CodCliente,e.IdPersona,t.codigo,t.Abreviatura,d.bancos_imp,d.otros_campos,IFNULL(e.Password,'') as Password from ".$tabla." left join empre_cliente e on ".$tabla.".IdCliente=e.IdCliente left join persona p on e.IdPersona=p.IdPersona left join tipo_documentos t on p.TipoDoc=t.IdTipoDoc join tipo_documentos d on {$tabla}.tipodoc=d.idtipodoc   where ".$comprobante."=".$IdDoc;
/*echo $sql; exit;*/
$re                = mysqli_query($link,$sql);
$d                 = $re->fetch_object();
$serie             = $d->Serie;

$idempresa         = $d->IdMiEmpresa;
$codigoOrganizacion= $orgcodxw;
$serie             = $d->Serie;
$numdoc            = $d->NumDoc;
$NombreCliente     = $d->NomCliente;
$RucCliente        = $d->Ruc;
$DireccionCliente  = $d->DirecCliente;
$ContactoCliente   = $d->ContactoCliente;
$Abreviatura       = $d->Abreviatura;
$Dir_Cliente       = $DireccionCliente;
$NomVendedor       = $d->NomVendedor;
$NombreSede        = $d->Nombre_Sede;
$SimboloMoneda     = $d->SimboloMoneda;
$FechaVencimiento  = $d->FPago;
$DirenccionEntrega = $d->TransDireccionLlegada;
$DirenccionEntrega = Saltar_Dir($DirenccionEntrega, 57);
$FechaVencimiento  =  date_create($FechaVencimiento);
$FechaDocOrigen    = date_create($d->FechaDocOrigen);
$Descuento_Global  = ($d->DctoTotal>0) ? $d->DctoTotal : 0;
$ObsExternas       = $d->ObsExternas;
$TParcial          = $d->TParcial;
$subtotal          = $d->SubTotal;
$total             = $d->Total;
$NomMoneda         = $d->NomMoneda;
$NroGuiaRemision   = $d->NroGuiaRemision;
$NroOrdenCompra    = $d->NroOrdenCompra;
$CondicionPago     = $d->CondicionPago;
$CodCliente        = $d->CodCliente;
$Cod_tipodocCliente= $d->codigo;
$EstadoDoc         = $d->EstadoDoc;
$CodCliente        = $d->Password;
$data              = $acceder->DecodificaSpecialChar($d->XML);
$doc               = new DOMDocument();

$doc->loadXML($data);

$IdComprobante      = ($TipoDoc==1 || $TipoDoc ==3) ?  $d->IdComprobante : $d->IdNota ;
include_once dirname(__FILE__)."/phpqrcode/qrlib.php";

$sqlsII             = "SELECT * FROM modulos_config WHERE IdMiEmpresa = ".$idempresa;
$orga               = $codigoOrganizacion;

/*  URL ORGANIZACIÓN */

$sqlp               = "SELECT IdOrg,CodOrg FROM controlx.organizaciones WHERE CodOrg ='".$orga."'";
$resultado          = mysqli_query($link, $sqlp);
$row45              = mysqli_fetch_assoc($resultado);
$codigo_org         = $row45['IdOrg'];
$consulta1          = "SELECT * from efac_config where IdMiEmpresa = ".$idempresa;
$resultado1         = mysqli_query($link, $consulta1);

$master             = ($TipoDoc==7) ? "18" : "19";
$sqlncMotivo         = "SELECT cntrl.DescripCorta from notas nc inner join controlx.MasterContableD cntrl on(nc.MotivoDoc = cntrl.clave ) where cntrl.IdMasterContable=".$master." and nc.IdNota = ".$d->IdNota;
$sqlncMotivo         = ($TipoDoc==7 || $TipoDoc==8) ? mysqli_query($link, $sqlncMotivo)->fetch_object() : "";

$row1               = mysqli_fetch_array($resultado1);
$nro_auto           = $row1['nroAuto'];
$res                = mysqli_query($link, $sqlsII);
$Data               = array();
$PermFormatDoc     = $row1["PermFormatDocEfac"];
while($row = mysqli_fetch_assoc($res)):
  $Data[$row['Leyenda']] = $row['Valor'];
endwhile;

$mystring = $Data['ColumnasDetdoc'];
$find     = 'DCodAlternativo';
$pos      = strpos($mystring, $find);
if ($pos === false) {
  $cadena=",p.CodAlternativo ";
}else{
  $cadena="";
}

$NombreEmpresa    = $Data['NomMiEmpresa'];
$RucEmpresa       = $Data['ConfG_RUC'];
$DireccionEmpresa = $Data['ConfG_Dir'];
$EmailEmpresa     = $Data['ConfG_Email'];
$TelefonoEmpresa  = $Data['ConfG_Telef'];

$RutaImg    = "../Preferencias/".$codigoOrganizacion."/".$idempresa."/Imagenes/".$Data['Per_Logo'];
if (!file_exists($RutaImg)) {
  $RutaImg='';
}

$fechadoc   = $doc->getElementsByTagName("IssueDate")->item(0)->nodeValue;
$fecha      = date_create($fechadoc);
$encabezado ='<h5 style="margin:2px !important">'.utf8_encode($NombreEmpresa.'</h5>'.$DireccionEmpresa.'<br>'.$EmailEmpresa).'<br>'.$TelefonoEmpresa;
$imgSize    =  getimagesize($RutaImg);
$AddClass   = ($imgSize[0] > '200') ? 'resize' : '';
if ($imgSize[1]>=$imgSize[0]) {
  $AddClass   = ($imgSize[0] > '200' && $imgSize[1] > '120') ? 'resize_rectangle_vertical' : '';
}
// $xheigth   = ($imgSize[1] > '120') ? 'height="120"' : '';

 if ($TipoDoc==7 || $TipoDoc==8) { // NOTA  CRÉDITO Y DÉBITO

  $encabezado_doc_titulo = ($TipoDoc==7) ? ('NOTA DE CRÉDITO') : ("NOTA DE DÉBITO");
  $SerieOrigen = $d->SerieDocOrigen;
  $CorreOrigen = $d->NumDocOrigen;
  $DocOrigen       = $SerieOrigen."-".$CorreOrigen;

  $TipoDocumento = $d->TiDocOrigen;
  $TipoDocumento = ($TipoDocumento=='FA') ? 'FACTURA' : 'BOLETA';
  $Motivox       = strtoupper(utf8_encode($sqlncMotivo->DescripCorta));
  $anexo        = '<tr><td valign="top"><b>Motivo</b></td><td valign="top">'.$Motivox.'</td><td align="right"><b>Doc.Relacionado </b></td><td align="right">'.$SerieOrigen.'-'.$CorreOrigen.'-'.$TipoDocumento.'</td></tr>';
  $SerieCorre = $SerieOrigen.'-'.$CorreOrigen;
}
else if ($TipoDoc==1 || $TipoDoc==3) { //FACTURA Y BOLETA

  $encabezado_doc_titulo = ($TipoDoc==1) ? 'Factura': 'Boleta';
  $SerieCorre     = $serie.'-'.$numdoc;
}

$TaxTotal = $doc->getElementsByTagName("TaxTotal")->item(0);

$igv=($TaxTotal=='')?$d->Igv:$TaxTotal->getElementsByTagName("TaxAmount")->item(0)->nodeValue;



//$igv      = $TaxTotal->getElementsByTagName("TaxAmount")->item(0)->nodeValue;

$resumen  = $doc->getElementsByTagName("DigestValue")->item(0)->nodeValue;


//COLORES
$colorP = '#8AB1CD';
$colorS = '#CCC';
if($d->otros_campos!=''){
    $otros_campos = json_decode(urldecode($d->otros_campos));
    $colorP = $otros_campos->colorP;
    $colorS = $otros_campos->colorS;
}
//END


?>
<html>
<head>
  <meta charset="utf-8">
  <title>Comprobante Electronico</title>
  <style>
  .resize{width: 200px; max-height: 120px;}
  .resize_rectangle_vertical{width: auto; height: 120px;}
  </style>
</head>
<body style="font-size:11px;">
<div style="margin-top: 10px;margin-left: -27px;width: 730px;">

  <table style="width:700px">
    <tr>
      <td style="width:200px;text-align: center;padding:10px 0px">
        <?php if($RutaImg!='') {
          ?>

        <img src="<?php echo $RutaImg;?>" class="<?php echo $AddClass;?>" <?=$xheigth?> >
        <?php } ?>
      </td>
      <td style="width:315px;text-align: right;">
        <?php echo $encabezado; ?> <br>
        <span style="font-size: 7pt;margin-top:4px">
        <?php

        $Options =json_decode($PermFormatDoc)[1]->Talonario;

        $Campos = [
          "sedesnomdir"=>["mi_sede","NomSede,Direccion","SEDES","where visible_imp=1 and IdMiEmpresa=".$idempresa.""],
          "sedestel"=>["mi_sede","NomSede,Telefono","SEDES","where IdMiEmpresa=".$idempresa.""],
          "ctasbancarias"=>["caja_banco ,bancos","bancos.NombreBanco,(SELECT tipm.Simbolo FROM tipo_moneda tipm WHERE tipm.IdTipoMoneda=caja_banco.IdMoneda) NomMoneda,caja_banco.NumCta,caja_banco.cci,caja_banco.Nombre","BANCOS","where caja_banco.IdMiEmpresa=".$idempresa." and caja_banco.IdBanco = bancos.IdBanco and caja_banco.Tipo ='B' and visible_imp=1 group by caja_banco.NumCta order by idcajabco asc"],
          "condpag"=>["",$CondicionPago,"INDEPENDIENTE","Condicion Pago"],
          "persconta"=>["",$ContactoCliente,"INDEPENDIENTE","Contacto"],
          "tipoper"=>"",
          // "moncompro"=>["",$NomMoneda,"INDEPENDIENTE","Moneda"],
          "vend"=>["",$NomVendedor,"INDEPENDIENTE","Vendedor"],
          "condi"=>["",$ObsExternas,"INDEPENDIENTE","Condiciones"],
          "codclie"=>["",$CodCliente,"INDEPENDIENTE","Cod.Cliente"],
          "telclie"=>"Telef",
          "correlect"=>"",
          "nroguiaremision"=>["",$NroGuiaRemision,"INDEPENDIENTE","Guia Remision"],
          "nroordencompra"=>["",$NroOrdenCompra,"INDEPENDIENTE","Orden de Compra"],
          "paginaweb"=>["mi_empresa","Url as Web","Web","where IdMiEmpresa = ".$idempresa.""],
          "lugarentrega"=>["",$TransDireccionLlegada,"INDEPENDIENTE","Lugar de Entrega"],
          "pesototalproductostal"=>["comprobante_venta_detalle","CodProducto,Cantidad, SUM(Cantidad*(select productos.valorpeso from productos where productos.codproducto = comprobante_venta_detalle.CodProducto)) PesoTotal","PESO","where IdComprobante=".$IdDoc.""],
          "fechavencimiento"=>["",date_format($FechaVencimiento, 'd-m-Y'),"INDEPENDIENTE","F. Vencimiento"],
          "emisiondocrela"=>["",date_format($FechaDocOrigen, 'd-m-Y'),"INDEPENDIENTE","F. Emisión Doc."]
          ];
        $CamposNoQuery =[];
        $arr_tipodoc = array("1"=>"Factura","3"=>"Boleta","7"=>"NotaCredito","8"=>"NotaDebito");
        $encabezado_doc= $arr_tipodoc[$TipoDoc];

        switch ($TipoDoc)
        {
          case 1:
            $x=0;

            for ($i=0; $i < count($Options); $i++)
            {
               //encabezado_doc = Tipo de documento (Boleta, Factura, etc)
              if (explode("_", $Options[$i])[1]==$encabezado_doc)
              {
                $valor = explode("_", $Options[$i])[0];
                if ($Campos[$valor][2]=="INDEPENDIENTE")
                {
                  $CamposNoQuery[$Campos[$valor][3]] = $Campos[$valor][1];
                  $x++;
                }else
                {
                  $BuildQuery[$Campos[$valor][1]] = array($Campos[$valor][0],$Campos[$valor][3]);
                  $Group[$Campos[$valor][1]] = $Campos[$valor][2];
                }
              }
            }
              $ConsultaQuery[$encabezado_doc] = $BuildQuery;
              $Grupo[$encabezado_doc] = $Group;
              $ValoresArray[$encabezado_doc] = $CamposNoQuery;
            break;
          case 3:
             $x=0;
            for ($i=0; $i < count($Options); $i++)
            {
               //encabezado_doc = Tipo de documento (Boleta, Factura, etc)
              if (explode("_", $Options[$i])[1]==$encabezado_doc)
              {
                $valor = explode("_", $Options[$i])[0];
                if ($Campos[$valor][2]=="INDEPENDIENTE")
                {
                  $CamposNoQuery[$Campos[$valor][3]] = $Campos[$valor][1];
                  $x++;
                }else
                {
                  $BuildQuery[$Campos[$valor][1]] = array($Campos[$valor][0],$Campos[$valor][3]);
                  $Group[$Campos[$valor][1]] = $Campos[$valor][2];
                }
              }
            }
              $ConsultaQuery[$encabezado_doc] = $BuildQuery;
              $Grupo[$encabezado_doc] = $Group;
              $ValoresArray[$encabezado_doc] = $CamposNoQuery;
            break;
            case 7:
            $x=0;
            for ($i=0; $i < count($Options); $i++)
            {
               //encabezado_doc = Tipo de documento (Boleta, Factura, etc)
              if (explode("_", $Options[$i])[1]==$encabezado_doc)
              {
                $valor = explode("_", $Options[$i])[0];
                if ($Campos[$valor][2]=="INDEPENDIENTE")
                {
                  $CamposNoQuery[$Campos[$valor][3]] = $Campos[$valor][1];
                  $x++;
                }else
                {
                  $BuildQuery[$Campos[$valor][1]] = array($Campos[$valor][0],$Campos[$valor][3]);
                  $Group[$Campos[$valor][1]] = $Campos[$valor][2];
                }
              }
            }
              $ConsultaQuery[$encabezado_doc] = $BuildQuery;
              $Grupo[$encabezado_doc] = $Group;
              $ValoresArray[$encabezado_doc] = $CamposNoQuery;
            case 8:
             $DocRelacionado = $anexo;
            break;
          default:
            # code...
            break;
        }
        $campos2 = "";
        //encabezado_doc = Tipo de documento (Boleta, Factura, etc)

        foreach ($ConsultaQuery[$encabezado_doc] as $key => $value)
        {
          //$value = es igual a la tabla
          //$key = es igual a los campos
          $value_ = $value[0];
          if ($campos2[$value_] == $campos[$value_])
          {
            foreach ($ConsultaQuery[$encabezado_doc] as $key2 => $value2)
            {
              $value2_=$value2[0];
              if ($value_ == $value2_ )
              {
                $table[$value_] = $value_;
                $campos[$value_] = $key;
                $campos2[$value_] = $campos2[$value_].",".$key2;
                $where[$value_] = $ConsultaQuery[$encabezado_doc][$key][1];
              }
            }

          $sel = "select ".substr($campos2[$value_], 1)." from ".$table[$value_]." ".$where[$value_];

          $querys[$Grupo[$encabezado_doc][$key]] = mysqli_query($link,$sel);
          }
        }

        foreach ($querys["SEDES"] as $key => $value)
        {
          print_r(($value["Direccion"]!=''?"<b>".utf8_encode($value["NomSede"].": </b>".($value["Direccion"])):'').($value["Telefono"]!=''?" <b>Tlf: ".$value["Telefono"]."</b>":'')."<br>");

        }
        foreach ($querys["Web"] as $key => $value) {
          print_r($value["Web"]!=''?"<b style='margin:3px 0px;'>".utf8_encode(trim($value["Web"]))."</b>":"");

        }
        // print_r($querys["Web"]);
        // exit();
      ?>
      </span>
      </td>
      <td valign="top" style="width:8px;"></td>
      <td valign="top" style="width:180px;border:2px solid black;padding: 15px 0px;text-align: center;font-size:16px;">
        <b>
          RUC: <?php echo $RucEmpresa;?><br><br>
          <?php echo strtoupper($encabezado_doc_titulo);?><br>
          ELECTR&Oacute;NICA<br>
          <?php echo $serie.' - '.$numdoc;?><br>
        </b>
      </td>
    </tr>
  </table>
  <br>
  <table style="width:700px;table-layout:fixed;" >
    <tr>
      <td style="width:90px;"><b>Señor(es) </b></td>
      <td style="width:370px;"><?php echo "".urldecode(utf8_encode($NombreCliente));?></td>
      <td style="width:90px;" align="right"><b>Moneda</b></td>
      <td><div style="width:140px;text-align:right"><?=$NomMoneda?></div></td>
    </tr>
    <tr>
      <td><b><?php echo ($Abreviatura!='') ? $Abreviatura : 'Doc' ?></b></td>
      <td><?php echo "".utf8_encode($RucCliente);?></td>
      <td align="right"><b>F. Emisión</b></td>
      <td><div style="width:140px;text-align:right"><?php echo date_format($fecha, 'd-m-Y'); ?></div></td>
    </tr>
    <tr>
      <td><b>Dirección</b></td>
      <td><div style="width: 370px;">
      <?php
        $direx = "".urldecode(utf8_encode($Dir_Cliente));
        if(substr_count($direx, ' - ')>=4){
          $first = explode(' - ',$direx,-2);
          $nuevad= implode(' ',$first);
          $sec   = explode(' ',$nuevad,-1);
          $solo_direc  = implode(' ',$sec);
          $solo_ubigeo = str_replace($solo_direc, "", $direx);
          echo $solo_direc."<br>".$solo_ubigeo;
        }else{
          echo $direx;
        }
      ?></div></td>
      <?php 
        if ((array_key_exists("F. Vencimiento",$CamposNoQuery))) {
          ?>
             <td align="right"><b>F. Vencimiento</b></td>
        <td><div style="width:140px;text-align:right"><?php echo date_format($FechaVencimiento, 'd-m-Y'); ?></div></td>

          <?php
        }

         ?>
        
     
    </tr>
    <?php if ($DocRelacionado) {echo $anexo; }
    $i=0;
    $cc=1;
    foreach ($ValoresArray[$encabezado_doc] as $key => $value)
    {
      if ($value!="" && $key!="Condiciones" && $key!="F. Vencimiento")
      {
          if ($cc==1) {
            $row .=  "<tr>";
            $align = 'align="left"';
          }
           if ($cc==2) {
            $align = 'align="right"';
          }
          $row .= "<td ".$align."><b>".$key." </b></td><td ><div style='width:140px;".$align.";'>".utf8_encode($value)."</div></td>";
          if ($cc==2) {
            $row .=  "</tr>";
            $cc=1;
          }else{
            $cc=2;
          }
        // }else{
        //     $row .=  "<tr>" ;
        //     $row .= "<td><b>".$key." </b></td><td>".$value."</td>";
        //     $row .=  "</tr>" ;
        // }
        $i++;
      }
    }
    if ($cc==2) {
      $row .= "</tr>";
    }
    echo  $row ;


    if ($cadena!='') {
      $widths = "270px;";
      $colspanx =2;
    } else{
      $colspanx =1;
      $widths = "360px;";
    }
?>
    </table>

    <br>

    <table style="width: 100%;">
      <tr  bgcolor="<?=$colorP?>" >
        <td style="height:18px;" bgcolor="<?=$colorP?>" border="1"  width="85"  align="center"  valign="middle"><b>CODIGO</b></td>
        <?php if ($cadena!='') { ?>
        <td style="height:18px;" bgcolor="<?=$colorP?>" border="1"  width="80"  align="center"  valign="middle"><b>CODIGO<br>SECUNDARIO</b></td>
        <?php } ?>
        <td style="height:18px;" bgcolor="<?=$colorP?>" border="1"  width="<?php echo $widths ?>"   align="center"  valign="middle">
          <b>DESCRIPCI&Oacute;N</b>
        </td>
        <td style="height:18px;" bgcolor="<?=$colorP?>" border="1"  width="50"   align="center"  valign="middle"><b>UNI</b></td>
        <td style="height:18px;" bgcolor="<?=$colorP?>" border="1"  width="50"   align="center"  valign="middle"><b>CANT.</b></td>
        <td style="height:18px;" bgcolor="<?=$colorP?>" border="1"  width="55"   align="center"  valign="middle"><b>V. VENTA</b></td>
        <td style="height:18px;" bgcolor="<?=$colorP?>" border="1"  width="50"   align="center"  valign="middle"><b>IMPORTE</b></td>
      </tr>
      <?php
      $query  = "select t.*".$cadena.",p.TipoControl,Lote,FVencimiento from ".$tabla2." t LEFT JOIN productos p on t.IdProducto=p.IdProducto where ".$campoId." = ".$IdComprobante;
      $result = mysqli_query($link,$query);
      $Descuento_Detalle = 0;
      $Valor_Unitario = 0;


      while ($fila = $result->fetch_object()) {

        $Precio_Unitario = $fila->PrecioVenta;
        $NombreProducto  = $fila->NomProducto;
        $CodigoProducto  = $fila->CodProducto;
        $Unidad          = $fila->NomUnidad;
        $Cantidad        = $fila->Cantidad;
        $importe         = $fila->Total;
        $DesAmpliada     = $fila->DetalleAmpliado;
        $Des_Detalle     = $fila->Dcto;
        $Descuento_Detalle  += ($Des_Detalle>0) ? $Des_Detalle : 0;

        $Id_Producto     = $fila->IdProducto;
        $campo           = $DesAmpliada;
        $Guias = explode(':',$d->IdDocOrigen);
        $guiasxn = $Guias[1]==''?0:$Guias[1];
        
        if($fila->TipoControl!=1 && $Id_Producto>0)
        {
          $consulta   = "SELECT * FROM alm_guia_det_ctrol h WHERE h.IdGuia IN (".$guiasxn.") AND h.IdProducto=".$Id_Producto;
          $resultado  = mysqli_query($link,$consulta);
          $count      = mysqli_num_rows($resultado);
          $campo     .= ($count>0) ? "\nS/N: " : "";
          while ($fila2 = $resultado->fetch_object()) {
            $dato   = $fila2->SerieNumero;
            $campo .= $dato.', ';
          }
          $campo =  rtrim($campo);
          $campo =  ($count>0) ? substr($campo,0, -1) : $campo;
        }

        if(($fila->Lote==1 || $fila->FVencimiento==1) && $Id_Producto>0 && $tabla!='notas' && $d->IdDocOrigen!='')
        {
          
          $sqlLt   = "SELECT Lote, DATE_FORMAT(FVencimiento,'%d-%m-%Y') AS FVencimiento FROM alm_guia_det_ctrol_sec WHERE IdGuia IN (".$guiasxn.") AND IdProducto='".$Id_Producto."' Group By Lote";
          $resLt  = mysqli_query($link,$sqlLt);
          $ccLt   = mysqli_num_rows($resLt);
          $campo .= ($ccLt>0) ? "\n" : "";
          while ($rowLt = $resLt->fetch_object()) {
          //   $dato   = $fila2->SerieNumero;
            $ccFv = ($rowLt->FVencimiento=='00-00-0000') ? "\n" : '<b>FV</b> '.$rowLt->FVencimiento."\n";
            $campo .= '<b>Lote</b> '.$rowLt->Lote.' &nbsp;&nbsp;'.$ccFv;
          }
          // $campo =  ($count>0) ? substr($campo,0, -4) : $campo;
        }



  ?>
        <tr>
            <td align="center"> <?php echo $CodigoProducto; ?></td>
            <?php if ($cadena!='') { ?>
            <td align="center"> <?php echo $fila->CodAlternativo; ?></td>
            <?php } ?>
            <td align="left">
              <div style="width:<?php echo $widths ?>;">
                <?php echo urldecode(utf8_encode($NombreProducto)); ?>
                <br>
                <!-- str_replace("<", "&lt;", $campo) -->
                <?php echo urldecode(utf8_encode(nl2br($campo))); ?>
              </div>
            </td>
            <td  align="center" >  <?php echo  $Unidad; ?></td>
            <td align="right">  <?php echo  number_format(round($Cantidad,2),2); ?></td>
            <td align="right">  <?php echo number_format(round($Precio_Unitario,3),3); ?></td>
            <td align="right">  <?php echo number_format(round($importe,3),3); ?></td>
        </tr>
<?php
      }
      // fin del while

    if ($Descuento_Detalle==0 && $Descuento_Global==0) {
        $DescuentoTotal = 0;
    }else {
        $a1 = $doc->getElementsByTagName("UBLExtensions")->item(0);
        $a2 = $a1->getElementsByTagName("UBLExtension")->item(0);
        $a3 = $a2->getElementsByTagName("ExtensionContent")->item(0);
        $a4 = $a3->getElementsByTagName("AdditionalInformation")->item(0);
        $filas = $a4->getElementsByTagName("AdditionalMonetaryTotal")->length;
        for ($xx = 0; $xx < $filas; $xx++) 
        {
            $a5 = $a4->getElementsByTagName("AdditionalMonetaryTotal")->item($xx);
            $NumTag = $a5->getElementsByTagName("ID")->item(0)->nodeValue;
            if($NumTag=='2005'){
                $DescuentoTotal = $a5->getElementsByTagName("PayableAmount")->item(0)->nodeValue;    
            }
        }
    }
?>

        <tr><td></td></tr>
          <tr>
            <td colspan="5"> <span class=""> </span> </td>
        </tr>
        <?php if($DescuentoTotal>0){ ?>
        <tr>
              <td colspan="<?php echo   $colspanx  ?>" align="center"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td colspan="2" bgcolor="<?=$colorP?>" border="1" align="right"><b>VALOR DE VENTA <?php echo ' '.$SimboloMoneda; ?></b></td>
              <td><div style="width:70px;" align="right"><?php echo " ".number_format(round($TParcial,2),2);?></div></td>
        </tr>
        <tr>
              <td colspan="<?php echo   $colspanx  ?>" align="center"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td colspan="2" bgcolor="<?=$colorP?>" border="1" align="right"><b>DESCUENTOS <?php echo ' '.$SimboloMoneda; ?></b></td>
              <td><div style="width:70px;" align="right"><?php echo " ".number_format(round($DescuentoTotal,2),2); ?></div></td>
        </tr>
        <?php } ?>
        <tr>
              <td colspan="<?php echo   $colspanx  ?>" align="center"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td  colspan="2" bgcolor="<?=$colorP?>" border="1" align="right"><b>SUB TOTAL <?php echo ' '.$SimboloMoneda; ?></b></td>
              <td><div style="width:70px;" align="right"><?php echo " ".number_format(round($subtotal,2),2);?></div></td>
        </tr>
        <tr>
              <td colspan="<?php echo   $colspanx  ?>" align="center"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td  colspan="2" bgcolor="<?=$colorP?>" border="1" align="right"><b>IGV <?php echo ' '.$SimboloMoneda; ?></b></td>
              <td><div style="width:70px;" align="right"><?php echo " ".number_format(($igv),2);?></div></td>
        </tr>
        <tr>
              <td colspan="<?php echo   $colspanx  ?>" align="center"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td colspan="2" bgcolor="<?=$colorP?>" border="1" align="right"><b>TOTAL <?php echo ' '.$SimboloMoneda; ?></b></td>
              <td><div style="width:70px;" align="right"><?php echo " ".number_format(round($total,2),2);?></div></td>
        </tr>
      </table>
    <br>
<?php
    $MontoTotal = round($total,2);
?>
    <span style="border-top:1px dotted #000;"><?php echo "SON ". numerotexto($MontoTotal)." ".$NomMoneda?></span><br>
    <hr>
    <style type="text/css">
    .bancos_ table {
    border-collapse: collapse;
    width: 100%;
    }

    .bancos_ th, .bancos_ td {
    text-align: center;
    padding: 2px;
    }
    .bancos_ td
    {
    }
    .bancos_ tr:nth-child(even){background-color: #f2f2f2}

    .bancos_ th {
    background-color: #3D3D3D;
    color: white;
    }
    a {
    text-decoration: none;
    all: revert;
    }
    </style>
<?php
    echo ($EstadoDoc=='Anulado') ? "<h1 style='text-align:center;color:#DA1818;'>".strtoupper($EstadoDoc)."</h1>" : "";
    foreach ($querys["PESO"] as $key => $value) {
    print_r($value["PesoTotal"]!=""?"<b>Peso Total: </b>".round($value["PesoTotal"],2)." Kg":"");
    }
    print_r("<br>".$ValoresArray[$encabezado_doc]["Condiciones"]);
?>
<table border="0" >

<?php
    $TipoDoc    = (strlen($TipoDoc)==1) ? "0".$TipoDoc : $TipoDoc;
    $total_qr   = number_format(round($total,2),2);
    $numdoc_qr  = str_pad($numdoc,6,'0',STR_PAD_LEFT);
    $fecha_qr   = date_format($fecha, 'd/m/Y');
    $codigo_qr  = $RucEmpresa." | ".$TipoDoc." | ".$serie." | ".$numdoc_qr." | ".$igv." | ".$total_qr." | ".$fecha_qr." | ".$Cod_tipodocCliente." | ".$RucCliente." |";
    QRcode::png($codigo_qr, dirname(__FILE__)."/imagen/imagenQR.png",QR_ECLEVEL_Q);
    $RutaImg2="../Componentes/efac/ModInfoReceptor/xmlFile/imagen/imagenQR.png";


 if ($querys["BANCOS"] != "")
 {
  ?>
<tr>
      <td colspan="2">
          <table class="bancos_" border="0">
          <thead>
            <tr>
              <th >
                  DESCRIPCIÓN
              </th>
              <th >
                  BANCO
              </th>
              <th >
                  MON
              </th>
              <th >
                  CUENTA
              </th>
              <th >
                  CCI
              </th>
            </tr>
          </thead>
          <tbody>

        <?php
        foreach ($querys["BANCOS"] as $key => $value) {
          ?>
            <tr style="font-size: 10px;">
            <td style="text-align: left;" width="180px;">
                   <?php echo $value["Nombre"] ?>
              </td>
              <td style="text-align: left;" width="180px;">
                   <?php echo $value["NombreBanco"] ?>
              </td>
              <td width="" >
                  <?php echo $value["NomMoneda"] ?>
              </td>
              <td width="142px;">
                  <?php echo $value["NumCta"] ?>
              </td>
              <td width="142px;">
                  <?php echo $value["cci"] ?>
              </td>
            </tr>
          <?php
          //print_r($value);
          //print_r($value);
        }

         ?>
          </tbody>

          </table>

      </td>

  </tr>

  <?php
 }

  $orgx=encryptx($row45['CodOrg'], 'Greed');
  $IdDocx = encryptx($IdDoc, 'Greed');
  $Tipodoc = encryptx($Tipodoc, 'Greed');
  $hrefI="http://fac.gestionx.com/?e=".$idempresa.'.'.$codigo_org.'&p='.$Tipodoc."and".urlencode($IdDocx)."andsky".$orgx."skyTal";
  ?>
  <tr>
      <td >
          <div style="padding-left: 5px;padding-top: 10px;width:520px;text-align: left;">

            <b>Resumen: </b><?=$resumen;?>
            <?php echo ($nro_auto!='') ? "<br>Autorizado mediante R.S. N° ".$nro_auto."<br>" : "<br>";//Autorizado Mediante Resolución de Intendencia: N° ".$nro_auto."/ SUNAT.<br>?>
            Representación impresa de la  <?=$encabezado_doc_titulo; ?> Electrónica <?php echo ' '.$serie.'-'.$numdoc; ?>.<br>
            <?php echo ($CodCliente != "" ? ("Código de Cliente: ".$CodCliente) : "") ?><br>
            Para consultar sus comprobantes electrónicos, puede ingresar al portal: <a style="color:black;text-decoration:none !important;" href="http://fac.gestionx.com/?e=<?php echo $idempresa.".".$codigo_org."&p=".urlencode($_GET['d']); ?>" target="_blank">fac.gestionx.com?e=<?php echo $idempresa.".".$codigo_org?></a>
            <br> <br><br
            >www.skyneterp.com

          </div>
      </td>
      <td>
        <div style="width:150px;text-align: center;">
            <img border= "2" width="120" height="120" src="<?php echo $RutaImg2;?>" alt="" id="RemoveImg">
      </div>
      </td>
    </tr>
</table>


</div>
</body>
</html>
