<h1><strong>Description</strong></h1>


SARA is a service-oriented platform for the management of community-based projects. Although it was initially 
developed for rural communities organized as Community Action Boards (JACs)*, as described in [1], 
the approach presented in this work adopts a more generic structure oriented toward different types of community-based 
organizations and social intervention contexts. 

SARA-Reg has been progressively adopted in different community-based project management contexts beyond its initial 
deployment with Community Action Boards, supporting the registration and monitoring of projects in diverse 
organizational settings. In this proposal, SARA serves as the operationalizing environment in which a new 
indicator-generation module, called SARA-Ind, is incorporated.

SARA-Ind operates as an extension of the original platform and relies on the structured project data 
generated and managed through SARA-Reg. Consequently, the indicator-generation process depends on the 
prior registration, monitoring, and consolidation of project information within the base system. 
Understanding this base system is necessary to explain the integration and data flow.

In summary, SARA-Reg manages project data through the proposed management model, while SARA-Ind transforms this data into indicators through 
aggregation, computation, and multi-level visualization. This work focuses on SARA-Ind, and an example of this process is shown in the following figure.


![Components of the SARA architecture](img/fig0_proceso.jpg)


For a more detailed implementation, please refer to the <a href="https://github.com/urbanoeliecer/Sara-Ind " target="_blank">GIT</a> repository.
