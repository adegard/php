# php-SQL

Some usefull scripts




<h1> Examples of SQL INNER JOIN </h1>

'retrieve list of workers who are working with us' 

SELECT relationship.lav_id, relationship.dti,plus_lav.name, plus_lav.tel, plus_lav.password
FROM relationship 
INNER JOIN plus_lav ON relationship.lav_id = plus_lav.mem_id

where dti != '0000-00-00' and password=""
order by plus_lav.name



'retrieve list of working realtionships from one particolar worker' 

SELECT relationship.lav_id, relationship.dti,plus_lav.name, plus_lav.tel, plus_lav.password
FROM relationship 
INNER JOIN plus_lav ON relationship.lav_id = plus_lav.mem_id

where dti != '0000-00-00' and `lav_id` ='1590' and password=""
order by plus_lav.name
