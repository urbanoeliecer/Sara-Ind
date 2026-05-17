# Principal page

Based on the results achieved with SARA-Reg and the increased adoption of the system by JACs, there is a need to incorporate new functionalities aimed at users from territorial entities. 

The SARA architecture is composed of the following components presented in the figure:
<ol>
<li>A web application structured in model and controller layers, along with a front-end that allows coordinators to manage information through a web browser. </li>
<li>A mobile application through which JAC participants manage information related to community projects.</li>
<li>A database responsible for storing project-related information.</li>
<li>A REST API that enables data migration and integration.</li>
<li>IoT sensors that collect climatic data from the rural area.</li>
<li>A Google Maps component that allows the geographical identification of rural elements such as roads, properties, culverts, aqueducts, among others.</li>
</ol>
![Components of the SARA architecture](img/fig2_saraArq.jpg)

Access to information depends on the user’s administrative hierarchy, whether municipal, departmental, or national. 

This hierarchy determines whether the user can view municipal-level data, departmental data, or information from all departments, according to the filters loaded at login, as shown in Figure.

Accordingly, the following information consolidation criteria are defined:<br>
<ol>
<li>1. When consolidating by community, totals are obtained per system and supersystem.</li> 
<li>2. When consolidating by supersystem, totals are obtained per system and community.</li> 
<li>3. When consolidating by system, information is consolidated by community.</li>
</ol>

![Filters](img/fig0_filtros.jpg)

The options are:
<ol>
<li>Interventions</li>
<li>General</li>
<li>Infrastructure or Elements</li>
</ol>