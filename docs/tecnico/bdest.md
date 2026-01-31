# SARAInd - Database

The database is presented in Figure and can be understood by reading it in the order:

1. Community action boards (**juntas**) are beneficiary community-based entities responsible for implementing projects in coordination with territorial entities.
2. **Projectos**, with attributes such as JAC Id, start and end dates, budget, and beneficiaries.
3. Project goal descriptions (**juntasdsc**), with attributes such as ID, execution periods, status, and goals per municipality, per JAC, and per period, in terms of number of projects, participants, and budget.
4. **Usuario**s are included to determine who can access and the role assigned to each user.
5. One of these users may act as a **representantes** for a defined period.
6. In addition, each project includes **elementos** that are intervened by the community.
7. These elements are associated with projects (**telementosproyectos**).
8. Activities executed by users are recorded for each project (**pryact**).
9. Each JAC is associated with a municipality.
10. Each municipality is associated with a department.
11. Each project must be associated with a JAC, and to facilitate data querying, a database view was created with the required attributes for indicators generation **vproyectosjunta**).

![Estructura](../img/bd.jpg)