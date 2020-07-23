<?php
				//traer conexion
require("funciones/conexion.php");

$query=" CREATE OR REPLACE VIEW viewsowing AS
SELECT a.fecha,'' AS finca,v.producto,a.variedad,a.temporada,a.tipo,b.fecha_pico,sum(a.valor) as valor FROM labors_sowing as a 
LEFT JOIN seasons as b on b.nombre=a.temporada
LEFT JOIN varieties AS v ON v.nombre=a.variedad
WHERE a.valor>0
GROUP by a.fecha,a.variedad,a.temporada,a.tipo,b.fecha_pico,finca
UNION
SELECT a.fecha_siembra,a.finca,v.producto,a.variedad,a.temporada_obj,'TEO_SIEMBRA' AS tipo,b.fecha_pico,sum(a.plantas) FROM programf as a 
LEFT JOIN seasons as b on b.nombre=a.temporada_obj
LEFT JOIN varieties AS v ON v.nombre=a.variedad
WHERE a.plantas>0 
GROUP by a.fecha_siembra,a.variedad,a.temporada_obj,a.tipo,b.fecha_pico,a.finca
UNION
SELECT a.fecha_ensarte,'' AS finca,v.producto,a.variedad,a.temporada_obj,'TEO_ENSARTE' AS tipo,b.fecha_pico,sum(a.plantas) FROM program as a
LEFT JOIN seasons as b on b.nombre=a.temporada_obj
LEFT JOIN varieties AS v ON v.nombre=a.variedad
WHERE a.plantas>0 
GROUP by a.fecha_ensarte,a.variedad,a.temporada_obj,a.tipo,b.fecha_pico,finca 
UNION
SELECT a.fecha_cosecha,'' AS finca,v.producto,a.variedad,a.temporada_obj,'TEO_COSECHA' AS tipo,b.fecha_pico,sum(a.plantas) FROM program as a 
LEFT JOIN seasons as b on b.nombre=a.temporada_obj
LEFT JOIN varieties AS v ON v.nombre=a.variedad
WHERE a.plantas>0 
GROUP BY a.fecha_cosecha,a.variedad,a.temporada_obj,a.tipo,b.fecha_pico,finca
UNION
SELECT a.fecha_siembra,a.finca,v.producto,a.variedad,a.temporada,'SIEMBRA' as tipo,b.fecha_pico,sum(a.plantas) FROM hplane as a 
LEFT JOIN seasons as b on b.nombre=a.temporada
LEFT JOIN varieties AS v ON v.nombre=a.variedad
WHERE a.plantas>0 
GROUP BY a.fecha_siembra,a.variedad,a.temporada,b.fecha_pico,a.finca
";

$conexion->query($query);
echo $query;

?>