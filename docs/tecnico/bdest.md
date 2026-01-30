# Base de datos Sistema SARA

La base de datos de Sara-Ind puede ser comprendida leyendola en el siguiente orden según las entidades:

1. Las **juntas** son la entidad beneficiaria sobre la que se generan y tienen:
2. **proyectos** (con atributos como idjunta, fecha de inicio y final, presupuesto, cantidad de beneficiarios)
3. descripción de metas del proyecto (**tuntasdsc**) con atributos como idjunta y cantidad de proyectos, participantes y presupuesto.
4. Tiene **usuarios** para saber quien puede acceder a SARA y el rol que le pertenece
5.  en donde uno de ellos puede ser el **representante** por un periodo de tiempo.
6. Además, el proyecto tiene **elementos** que son intervenidos por la comunidad que,
7. se asocian (**telementosproyectos**) a los proyectos, en los que se realizan,  
8. actividades que son realizadas por usuarios (**pryact**).
9. La junta está adscrita a un **municipio**,
10. que está adscrito a un **departamento**
11. Cada proyecto debe asociarse a una junta y para ello se construyó una vista (**vproyectosjunta**).


![Estructura](../img/bd.jpg)