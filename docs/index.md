# SARA II - Index 

Web Application Based on a Service-Oriented Architecture for Measuring the Impact of Rural Infrastructure Projects in Community Action Boards SARA II is a web-based application developed as a result of Project 4271 of the VIE at UIS, its source code repository is hosted at <a href="https://github.com/urbanoeliecer/Sara00" target="_blank" rel="noopener">https://github.com/urbanoeliecer/Sara00</a>.

The application generates reports and intervention indicators related to rural infrastructure based on the information managed within SARA, a cloud-based architecture designed to support the management of rural community projects. carried out by Community Action Boards (Juntas de Acción Comunal, JAC), with the support of territorial entities. 

Rural communities are commonly managed by groups organized as Community Action Boards, which face specific challenges related to access to basic services. In addition, they often experience limitations in information availability and management, making it difficult to monitor and manage community projects effectively. 
In the Colombian context, JACs are primarily composed of families engaged in agricultural, livestock, and other rural-related activities, and they are located in areas with a population density of fewer than 150 inhabitants per square kilometer. 

The SARA I architecture is composed of the following components presented in the figure:
<ol>
<li>A web application structured in model and controller layers, along with a front-end that allows coordinators to manage information through a web browser. </li>
<li>A mobile application through which JAC participants manage information related to community projects.</li>
<li>A database responsible for storing project-related information.</li>
<li>A REST API that enables data migration and integration.</li>
<li>IoT sensors that collect climatic data from the rural area.</li>
<li>A Google Maps component that allows the geographical identification of rural elements such as roads, properties, culverts, aqueducts, among others.</li>
</ol>
![Components of the SARA architecture](img/sara.jpg)
<br><br>
In this context, SARA II extends the capabilities of the original system by providing a specialized module for indicator analysis and visualization, using data recorded in SARA 1.0. SARA II is a new system module that enables the calculation and analysis of indicators related to projects, participants, resources, intervened elements, and participation comparisons, both at the municipal and departmental levels.
