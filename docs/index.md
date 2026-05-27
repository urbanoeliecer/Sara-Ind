# **Index**

This product is a web-based system and a multi-level indicator framework for the systematic generation and consolidation of intervention indicators 
in community-based projects. The proposal is oriented toward organizations such as foundations, educational institutions, and other entities that 
execute social impact initiatives, enabling the processing of structured project information including activities, resources, participants, timelines, 
budgets, and intervened elements.

The options are:
<ol>
<li>Interventions</li>
<li>General Intervention</li>
<li>Infrastructure Intervention</li>
</ol>

The proposed application and indicator model were conceived with a generic structure that allows adaptation to different organizational contexts. The 
system is implemented as an indicator-generation module integrated into SARA, a previously proposed service-oriented project management platform [1]. 

Although SARA was initially designed for rural communities organized as Community Action Boards (Juntas de Acción Comunal*, JACs) in Colombia [2], 
the approach presented in this work generalizes the project management and territorial consolidation model to support broader organizational contexts, 
using generic structures such as supersystems, systems, and communities. This generalization is supported by the progressive adoption of the platform 
in different community-based project management contexts beyond its initial deployment.

The proposed solution is based on a modular cloud architecture with loosely coupled services, enabling reuse and evolution through APIs, and supporting the generation of indicators across multiple levels and time periods. SARA-Ind follows an exploratory–descriptive approach and was developed using the Rational Unified Process (RUP) through incremental, use case–driven iterations, resulting in a functional solution deployed for end users 

[1] <a href="https://acofipapers.org/index.php/eiei/article/view/4844" target="_blank">1</a>
[2] <a href="https://www.oecd.org/en/publications/rural-policy-review-of-colombia-2022_c26abeb4-en.html" target="_blank">2</a>

* In the Colombian context, JACs are primarily composed of families engaged in agricultural, livestock, and other rural-related activities, and 
they are located in areas with a population density of fewer than 150 inhabitants per square kilometer. 

<p>
SARA was developed as part of Project 4271 of the VIE by <strong>Urbano Eliécer Gómez-Prada</strong><br>
School of Systems Engineering, Universidad Industrial de Santander<br>
Bucaramanga, Colombia — <a href="mailto:uegomezp@uis.edu.co">uegomezp@uis.edu.co</a><br>
2026
</p>

# Installation Guide

Requirements: Make sure you have a local server environment with: Apache, PHP 8.2 or higher,MariaDB or MySQL


Installation Steps:

[1] Clone the repository to the <a href="https://github.com/urbanoeliecer/Sara-Ind " target="_blank">GIT</a> repository.

[2] Place the folder in your web server directory (e.g., htdocs in XAMPP).

[3] Set up the database

4. Create a new database and import the SQL file included in the repository.

5. Configure the connection

6. Update the database credentials in the configuration file (e.g., functions/conexion.php).

7. Run the application http://localhost/Sara-Ind
