# Programming Environment


The image presents the implementation of an indicator following the Model–View–Controller (MVC) architecture. The controller coordinates the execution flow, the model retrieves and processes the 
required data, and the view generates the corresponding HTML output for presentation.

This design enables a clear separation between business logic, data access, and visual representation, thereby improving the maintainability and scalability of the system.

<br>The components fulfill the following roles:

a. Controller: Validates the user session, loads the required files and components, and requests the indicator data from the model.

b. Model: Executes the database queries using the filters provided by the controller and returns the resulting dataset.

c. View: Receives the dataset produced by the model and generates the HTML output used to present the indicator to the user.<br><br>

![EDS](../img/fig0_EDS.jpg)

