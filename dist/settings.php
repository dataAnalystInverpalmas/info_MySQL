<?php
require("funciones/conexion.php");
 ?>
 <div class="card">
   <div class="card-header">
     <div class="dropdown dropleft float-right">
       <button type="button" class="btn btn-primary dropdown-toggle " data-toggle="dropdown">
         Tables
       </button>
       <div class="dropdown-menu">
         <a class="dropdown-item" href="index.php?menu=se&set=1">Actualizar plantas</a>
         <a class="dropdown-item" href="index.php?menu=se&set=2">Actualizar grados</a>
         <a class="dropdown-item" href="index.php?menu=se&set=3">Actualizar tabla indices</a>
         <a class="dropdown-item" href="index.php?menu=se&set=4">Actualizar producto y finca</a>
       </div>
   </div>
 </div>
</div>


 <!--Filtros de acuerdo a la pagina--------------------------------------------------->
 <?php if (empty($_GET['set'])){ ?>
home
<?php }else if (($_GET['set'])==1){ //si tiene el valor 1 traera el primer informe
  $act="UPDATE exportados as e INNER JOIN plantas AS p ON (e.ano=p.ano) AND (e.mes=p.mes)
  AND (e.producto=p.producto) SET e.plantas=(SELECT SUM(p.plantas) from plantas as p
  WHERE (e.ano=p.ano) AND (e.mes=p.mes) AND (e.producto=p.producto) GROUP BY p.producto)";
  $res = $conexion->query($act);
?>
 </div>
 </div>
<?php }else if (($_GET['set'])==2){ //actualizar grados///////////////////////////

$act="UPDATE exportados SET grado='a.SEL' WHERE grado='SEL' ";
$res = $conexion->query($act);
$act="UPDATE exportados SET grado='b.FAN' WHERE grado='FAN' ";
$res = $conexion->query($act);
$act="UPDATE exportados SET grado='c.STD' WHERE grado='STD' ";
$res = $conexion->query($act);
$act="UPDATE exportados SET grado='d.SHR' WHERE grado='SHR' ";
$res = $conexion->query($act);
$act="UPDATE exportados SET grado='e.80CM' WHERE grado='080' ";
$res = $conexion->query($act);
$act="UPDATE exportados SET grado='f.60CM' WHERE grado='060' ";
$res = $conexion->query($act);
$act="UPDATE exportados SET grado='g.50CM' WHERE grado='050' ";
$res = $conexion->query($act);
$act="UPDATE exportados SET grado='h.40CM' WHERE grado='040' ";
$res = $conexion->query($act);
$act="UPDATE exportados SET grado='i.GRA' WHERE grado='GRA' ";
$res = $conexion->query($act);
$act="UPDATE exportados SET grado='j.NAL' WHERE grado='NAL' ";
$res = $conexion->query($act);

}else if (($_GET['set'])==3){ //tabla de indices generales//////////////////////
  $limpiar="TRUNCATE TABLE indicespro";
  $res=$conexion->query($limpiar);

  $insertar="INSERT INTO indicespro
  SELECT P.PRODUCTO,P.VARIEDAD,P.ANO,
  SUM(case when P.GRADO='SEL' or P.GRADO='070' or P.GRADO='080' or P.GRADO='090' or P.GRADO='100' then P.tallos else 0 end) as 'SEL70CM',
  SUM(case when P.GRADO='STD' or P.GRADO='050' then P.tallos else 0 end) as 'STD50CM',
  SUM(case when P.GRADO='FAN' or P.GRADO='060' then P.tallos else 0 end) as 'FAN60CM',
  SUM(case when P.GRADO='SHR' or P.GRADO='040' then P.tallos else 0 end) as 'SHR40CM',
  SUM(case when P.GRADO='NAL' then P.tallos else 0 end) as 'NAL',
  SUM(P.tallos) as 'TTALLOS',
  SUM(P.tallos)-
  (SELECT sum(tallos) from procesados as PP where PP.grado='NAL' and (PP.variedad=P.variedad and PP.ano=P.ano and PP.variedad=P.variedad) and
  (PP.fuente='Clasificacion' or PP.fuente='Fitosanitario Cultiv' or PP.fuente='Dirigida'))
  as EXPTBLE,
  (SELECT sum(tallos) from documentos as D where (D.producto=P.producto and D.variedad=P.variedad and D.ano=P.ano) and causa='MERCADO')
  as BAJAS,
  (SELECT SUM(C.produccion)/avg(C.plantas)/
  (SELECT COUNT(DISTINCT C.bloque) FROM curvassc as C WHERE C.variedad=P.variedad)
  from curvassc as c where (c.variedad=P.variedad and c.ano=P.ano and c.producto=P.producto)) AS FPLANTA,
  (SELECT SUM(C.produccion)/avg(C.plantas)/
  (SELECT COUNT(DISTINCT C.bloque) FROM curvassc as C WHERE C.variedad=P.variedad)
  from curvassc as c where (c.variedad=P.variedad and c.ano=P.ano and c.producto=P.producto))*iF(p.producto='CLA' or P.producto='CM0',53,6.5) AS FPLANTAMT2
  FROM procesados as P
  WHERE (P.fuente='Clasificacion' or P.fuente='Fitosanitario Cultiv' or P.fuente='Dirigida')
  group by 1,2,3";
  $res = $conexion->query($insertar);
}else if (($_GET['set'])==4){ //actualizar grados///////////////////////////
  $act="UPDATE curvassc SET finca='INVERPALMAS' WHERE finca='001' ";
  $res = $conexion->query($act);
  $act="UPDATE curvassc SET finca='PALERMO' WHERE finca='002' ";
  $res = $conexion->query($act);

  $act="UPDATE exportados SET producto='CLAVEL' WHERE producto='CLA' ";
  $res = $conexion->query($act);
  $act="UPDATE exportados SET producto='MINICLAVEL' WHERE producto='CM0' ";
  $res = $conexion->query($act);
  $act="UPDATE exportados SET producto='ROSAS COLORES' WHERE producto='ROC' ";
  $res = $conexion->query($act);
  $act="UPDATE exportados SET producto='ROSAS ROJAS' WHERE producto='ROS' ";
  $res = $conexion->query($act);
}

 ?>
