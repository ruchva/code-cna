SELECT 
 p.id AS id_persona
,concat(p.nombre,' ',p.apellido, ' - Cedula: ', p.cedula, ' - Cargo: ', c.nombre) AS persona
FROM persona p
JOIN persona_cargo pc ON p.id = pc.fk_persona
JOIN cargo c ON c.id = pc.fk_cargo
--WHERE pc.fk_cargo = 4
ORDER BY p.id