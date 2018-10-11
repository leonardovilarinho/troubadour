# framework

#Install:
- Type 1: 
     composer create-project --prefer-dist legionlab/troubadour nome-do-projeto

- Type 2:
     composer global require "troubadour/installer" &&
     troubadour new nome-do-projeto

- Installing CRUD:
     composer create-project --prefer-dist legionlab/troubadour-example nome-do-projeto
     
     
#Starting:
Change the file /settings/setups.php, changing database login.

To access utilities such as Criteria, Language, and Pager, go to: https://github.com/legionlab/utils