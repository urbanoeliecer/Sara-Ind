# Home Page - Sara II - Measuring the Impact of Rural Infrastructure Projects

Web Application Based on a Service-Oriented Architecture for 
Measuring the Impact of Rural Infrastructure Projects in Community Action Boards
SARA II is a web-based application developed as a result of Project 4271, VIE–UIS, 
its source code repository is hosted at https://github.com/urbanoeliecer/Sara00.

The application generates reports and intervention indicators related to 
rural infrastructure based on the information managed within SARA, a cloud-based 
architecture designed to support the management of rural community projects.

SARA has been described is a cloud architecture composed of an information system
that facilitates the management of community-based rural projects carried out by 
Community Action Boards (Juntas de Acción Comunal, JAC), with the support of territorial entities. 

In this context, SARA II extends the capabilities of the original system by providing a 
specialized module for indicator analysis and visualization, using data recorded in SARA 1.0.
Rural communities are commonly managed by groups organized as Community Action Boards, 
which face specific challenges related to access to basic services. In addition, 
they often experience limitations in information availability and management, 
making it difficult to monitor and manage community projects effectively. 

In the Colombian context, JACs are primarily composed of families engaged in agricultural, 
livestock, and other rural-related activities, and they are located in areas with 
a population density of fewer than 150 inhabitants per square kilometer.
To address these challenges, SARA was developed as a platform to support the 
management of community projects. In order to strengthen indicator generation in particular, 

SARA II is proposed as a new system module that enables the calculation and analysis of 
indicators related to projects, participants, resources, intervened elements, and 
participation comparisons, both at the municipal and departmental levels.

SARA I is a cloud computing architecture for the management of rural Community Action Boards (Juntas de Acción Comunal, JAC), as described in [1]. This architecture provides access to coordinators from territorial entities, enabling them to monitor and control projects executed by JAC representatives and members. The different system roles are illustrated in Figure 1.
The SARA I architecture is composed of the following components:

1. A web application structured in model and controller layers, along with a front-end that allows coordinators to manage information through a web browser. On top of this component, SARA II has been implemented as a complementary module for generating the indicators and reports described in this document.
2. A mobile application through which JAC participants manage information related to community projects.
3. A database responsible for storing project-related information.
4. A REST API that enables data migration and integration.
5. IoT sensors that collect climatic data from the rural area.
6. A Google Maps component that allows the geographical identification of rural elements such as roads, properties, culverts, aqueducts, among others.

![Components of the SARA architecture](../img/componentes.jpg)
