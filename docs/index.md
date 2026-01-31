# Index 

SARA is a Web Application based on a Service-Oriented Architecture for Measuring the Impact of Rural Infrastructure Projects in Community Action Boards, is a web-based application developed as a result of Project 4271 of the VIE at UIS, its source code repository is hosted at <a href="https://github.com/urbanoeliecer/Sara-Ind" target="_blank" rel="noopener">github</a>.

Based on its use by several boards, the system was extended with a specialized module for indicator generation and analysis. As a result, SARA is now organized into two main modules: SARA-Reg, for project data registration, and SARA-Ind, which focuses on indicator generation.

<ol>
<li>SARA was developed as part of Project 4271 of the VIE by: **Urbano Eliécer Gómez-Prada**</li>
<li>School of Systems Engineering, Universidad Industrial de Santander</li>
<li>Bucaramanga – Colombia, [uegomezp@uis.edu.co](mailto:uegomezp@uis.edu.co)</li>
<li>2026</li>
</ol>

SARA is now organized into two main modules: SARA-Reg, for project data registration, and SARA-Ind, which focuses on the  generation if multiple indicators.

SARA generates reports and intervention indicators related to rural infrastructure based on the information managed within SARA, a cloud-based architecture designed to support the management of rural community projects. carried out by Community Action Boards (Juntas de Acción Comunal, JAC), with the support of territorial entities. 

Rural communities are commonly managed by groups organized as Community Action Boards, which face specific challenges related to access to basic services. In addition, they often experience limitations in information availability and management, making it difficult to monitor and manage community projects effectively. 

In the Colombian context, JACs are primarily composed of families engaged in agricultural, livestock, and other rural-related activities, and they are located in areas with a population density of fewer than 150 inhabitants per square kilometer. 

This application allows the generation of reports and intervention indicators in rural infrastructure based on the information managed in <a href="https://acofipapers.org/index.php/eiei/article/view/4844">SARA-Reg</a>.

On this page, the user enters their username and password, and the submitted credentials are validated in order to display the main menu. It should be noted that this page (index), the credential validation page (loginRev), the logout page (logOut), and the main menu page (principal) were added to the described module, since it has already been integrated into SARA within its Laravel framework. In this context, the module is presented in a simplified form using basic PHP and JavaScript to facilitate understanding.

In this context, SARA-Ind extends the capabilities of the original system by providing a specialized module for indicator analysis and visualization, using data recorded in SARA-Reg. SARA-Ind is a new system module that enables the calculation and analysis of indicators related to projects, participants, resources, intervened elements, and participation comparisons, both at the municipal and departmental levels.
