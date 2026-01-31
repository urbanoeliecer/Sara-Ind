# Programming Environment

The figure shows how two reports are being developed, one without MVC and one with MVC, as illustrated in Figure 15, sections 1 and 2. On the left side, the project components are organized according to their hierarchy.

Section 1 presents the controller for the RGI indicator detail, which is responsible for building the main SQL query, processing the results, and preparing the information that will later be displayed in the view. This section shows the construction of the SQL query, which integrates actual and expected information from community projects, including filters, forms, and related elements.

Section 2 presents the three required files for the monthly project activity report.

These components act as a bridge between the data layer and the presentation layer. Their design allows for a clear separation of business logic, data access, and visual representation, thereby improving maintainability and scalability.

They fulfill the following roles:

a. Analysis controller
b. Calculation of strategic indicators for decision making
c. Visual representation

On the left, the project components are presented organized according to their hierarchy.
![Entorno](../img/0.jpg)
