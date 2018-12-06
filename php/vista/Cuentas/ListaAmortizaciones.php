<h4>Lista Amortizacion Documento N° <?=$IdComprobante?></h4>
<?php 

?>
<div id='ListaAmortizaciones'>
<div class="row">
        <div class="col-md-8">
            <table class="table table-bordered">
                <tr>
                    <th style='line-height:6pt;'>Id</th>
                    <th style='line-height:6pt;'>Comprobante</th>
                    <th style='line-height:6pt;'>Fecha </th>
                    <th style='line-height:6pt;'>Monto</th>
                    <th style='line-height:6pt;'>Encargado</th>
                    <th style='line-height:6pt;'>Observaciones</th>                  
                    <th style='line-height:6pt;'>Acciones</th>
                    
                    
                </tr>
                <?php
                $TAmortizado=0;
                foreach ($ListaAmortizacion as $f) {
                    
                    $TAmortizado=$TAmortizado+$f['MONAMORTIZACION'];
                    echo "<tr>";
                    echo "<td style='line-height:5pt;'>".$f['IDCOMPROBANTE']."</td>";
                    echo "<td style='line-height:5pt;'>".$f['IDCOMPROBANTE']."</td>";
                    echo "<td style='line-height:5pt;'>S/".$f['FEAMORTIZACION']."</td>";
                    echo "<td style='line-height:5pt;'>S/".$f['MONAMORTIZACION']."</td>";
                    echo "<td style='line-height:5pt;'>".$f['IDUSUARIO']."</td>";
                    echo "<td style='line-height:5pt;'>".$f['OBSERVACION']."</td>";
                    echo "<td style='line-height:5pt;'>";?>
                    <i class="material-icons" style='cursor:pointer;' onclick="VerAmortizaciones('<?=$f['IDCOMPROBANTE']?>')">visibility</i>
                    <i class="material-icons" style='cursor:pointer;' onclick="Amortizar('<?=$f['SALDO']?>','<?=$f['IDCOMPROBANTE']?>');">equalizer</i>
                    <?php echo "</td>";
                    echo "</tr>";

                        
                    }
                ?>
            </table>
            <?='Total Amortizado S./ '.$TAmortizado?>
        </div>
	</div>

</div>
