# cpsc455spring2021

This is the repository for the project for Software Engineering for Spring 2021.  Folders should be created for the different parts of the application (e.g. a folder for the web app, a folder for design diagrams, a folder for a mobile app if we need one, etc).  

## Setup Notes

1) Clone this onto your system in the www folder of your Uniform Server install.  That will create a cpsc455spring2021 folder that contains everything.

2) Start Uniform Server and go to http://localhost and then click on PhpMyAdmin

3) Create a database named cpsc455spring2021

4) In that database click on the Privileges tab and click Add User Account

5) Add a user account named cpsc455user whose password is cpsc455spring2021password.  Be sure the host name is localhost.

6) In the database you created click Import and then Choose File.  Find the db_create.sql file in the database folder of your repository and import it.  That should create the Users and Roles table and insert our basic roles and test users.

## To Update The Repository

When you first start working with the repository, use Git Bash to do a *git pull* command so you make sure you are working with the latest version.

Be sure to commit often so you get the benefit of rolling back to previous versions if needed:

git add .
git commit -m "Put a commit message here"

When you are done with a feature and it works, use *git push* to update the Github repository.

