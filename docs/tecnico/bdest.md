# Base de datos Sistema SARA

La base de datos de Sara II puede ser comprendida leyendola en el siguiente orden según las entidades:

1. Las **juntas** son la entidad central sobre la que se generan y tienen:
2. **proyectos** (con atributos como id, idjunta, fecha de inicio y final, monto, cantidad de beneficiarios)
3. descripción de metas del proyecto (**tuntasdsc**) con atributos como idjunta y cantidad de proyectos, participantes y presupuesto.
4. Tiene **usuarios** para saber quien puede acceder a SARA y el rol que le pertenece
5  en donde uno de ellos puede ser el **representante** por un periodo de tiempo 
6. cada proyecto debe asociarse a una junta y para ello se construyó una vista (**vproyectosjunta**).
7. Además, el proyecto tiene **elementos** que son intervenidos por la comunidad y que, 
8. se asocian (**telementosproyectos**) a los proyectos, en los que se realizan,  
9. actividades que son realizadas por usuarios (**pryact**).
10. La junta está adscrita a un **municipio**,
11. que está adscrito a un **departamento**
![Estructura](../img/bd.jpg)