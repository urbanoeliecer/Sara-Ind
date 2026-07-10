# **Architecture**


The SARA architecture is composed of the following components presented in the figure:
<ol>
<li>A web application structured in model and controller layers, along with a front-end that allows coordinators to manage information through a web browser. </li>
<li>A mobile application through which JAC participants manage information related to community projects.</li>
<li>A database responsible for storing project-related information.</li>
<li>A REST API that enables data migration and integration.</li>
<li>IoT sensors that collect climatic data from the rural area.</li>
<li>A Google Maps component that allows the geographical identification of rural elements such as roads, properties, culverts, aqueducts, among others.</li>
</ol>
![Components of the SARA architecture](../img/fig2_saraArq.jpg)

<br>
#  MVC

<br>The following subsections describe the implemented indicators, including their structure, calculation approach, and interpretation. These indicators were 
implemented following the Model–View–Controller (MVC) architecture, as shown to next, this figure presents an example of the files involved in the General 
<br><br>Intervention Indicator process. The steps are as follows:

i. The user sends a request, which is handled by the controller.

ii. The controller validates the user session, invokes the required pages, and requests the corresponding data from the model.

iii. The model executes the database query according to the filters received from the controller.

iv. The model returns the resulting data to the view.

v. The view processes the data and generates the HTML indicator.

vi. The controller presents the generated indicator to the user.

<br><br>
All indicators are generated from data using the same set of filters, which can be applied by supersystem or system, by date range and page.
<br><br>
![Filters](../img/fig0_filtros.jpg)
