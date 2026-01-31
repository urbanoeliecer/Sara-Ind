# Requeriments

SARA-Ind generates five indicators based on the records created in SARA-Reg.
A summary of SARA-Reg is presented in [https://doi.org/10.26507/paper.4844](SARA Description).

# Community management system

The proposed system is process-oriented and interconnects municipalities, communities, and in-habitants, where some act as beneficiaries or managers, as well as projects involving activities with tools that consume certain resources to work on elements or infrastructure. Each project requires the support of a manager assigned by the municipality, who ensures the proper use of the resources ad-ministered by the community. For this reason, the manager must have access to information that pro-vides traceability and demonstrates the achievement of the project's goal.

The system aims to enhance the management of information for community projects, addressing inefficiencies that often result in duplicated efforts and wasted resources, and/or a lack of accurate information. The system structure is shown in Figure 2; its description is in the following points:

1. Municipalities are territorial entities made up of beneficiary communities.

2. Projects involve activities carried out with tools that improve elements consume resources.

3. The municipality must have a manager for to guide the projects who to work in the community.

4. Beneficiaries must assign activities, tools and elements.

5. The municipality is responsible for handling resources, it is guarantors of the communities.

6. Projects benefit the entire community.

![Structure of the Rural Community Administration System](../img/1.jpg)

# Cloud Architecture

The cloud architecture developed is a prototype, a first version that will transition to the adoption phase by the community. This architecture supports the proposed management system and involves applications for project management, initially focusing on community projects and climate variable measurement. 
 
A summary of the architecture requirements is as follows (points 3 and 4 can be carried out both on mobile and web platforms) and is represented in Figure 3:

1. Manage master data, primarily communities, participants, tools, activities, municipali-ties, and more.

2. Manage projects.

3. Manage activities, including location management via Google Maps.

4. Generate activity reports by project with filters for community, projects, date range, activity types, observations, multimedia, etc. Additionally, generate merged lists and graphs for com-munities, activities, users and funds.
 

![Simplified Use Case Diagram](../img/2.jpg)


The process is described in the activity diagram in Figure 4. It has three starting points based on the diamonds, corresponding to different moments:

1. When the municipality assigns a project to a community and maps its location, triggering a pending activity for the community president to accept the project. However, the initial step is when the community identifies the need, although this is not handled in the software.
 
2. When the community president assigns activities, members, and/or tools, occurring when se-lects the project.

3. When a community member replaces the president of the community board.

# Tecnique Requirements

SARA requires a MySQL database, a local server environment such as XAMPP, and the source code available in this GitHub repository.

The system is designed to run on Windows and requires PHP and Apache (included in XAMPP) to be properly configured.

Once the environment is set up, the project can be deployed by importing the database and configuring the application according to the provided source code.