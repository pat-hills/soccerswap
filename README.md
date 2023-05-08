# INSTALLATION/SETUP STEPS ON WINDOWS ENVIRONMENT

Before you start, make sure the project 'SoccerSwap' is cloned
from the repository with all files in the root directory of the 
'soccerswap' root folder directory.

App is remotely deploy/install here for remote testing/access:
https://www.spencamgroup.com/soccerswap/public/

Now lets start...(Windows Environment Deployment/Installation)

1. Xampp should be installed on your windows environment
   (Can be downloaded from here:)
   https://www.apachefriends.org/download.html


2. Make sure these services are running
   a. Apache Service
   b. Mysql Service


3. Be mindful of the port Apache is running on, incase the default port 80 was
   was change.
   Hint: if the default port was not change
   Local url would be: localhost:80 / localhost
   Incase it was change, it would be localhost:(Port #).
   Eg localhost:81, meaning the port was change to 81


4. Launch phpMyAdmin to see if mysql GUI is working
   Url should be :localhost:(Port #)/phpmyadmin/

(I'm assuming all our services required for our symfony app to run is up)

5. Create a database name called 'soccer_swap_db' from phpmyadmin

   i. From phpmyadmin, click on 'New' and enter, the name of the database, and
   accept the default option and click on create.

6. Import the database file called 'SOCCER_SWAP_DB' from the root directory
   of the project folder.
   
   i. From phpmyadmin, click on import and browse for the db file 'SOCCER_SWAP_DB'
   accept all default settings and click on 'IMPORT' button to import.

   (if it complains of foreign key constraint fails)

   Repeat the process 6 and uncheck option "Enable foreign key checks" to prevent phpMyAdmin
   checking the foreign key constraint and import the database.

7. Click on your database 'soccer_swap_db' to see all imported tables.

8. Copy the project and locate Xampp/htdocs directory from your drive C: i.e C:\xampp\htdocs
   paste it in the root directory of 'htdocs'

9. Edit the env. and change APP_ENV=prod
   DATABASE_URL="mysql://root:""@127.0.0.1:3306/soccer_swap_db?serverVersion=10.11.2-MariaDB"
   Make sure your connection, DATABASE_URL using 'root' is exactly as above, however if you have
   configured your 'root' user to have a password, enter the password. i.e

   DATABASE_URL="mysql://root:"password-here"@127.0.0.1:3306/soccer_swap_db?serverVersion=10.11.2-MariaDB"

   Any other database user can also replace 'root' with account password

10. Launch the application, go browser and enter URL below:
 
    http://localhost:80/soccerswap/public/
    http://localhost/soccerswap/public/

    Incase your apache runs on port 81, like in my case it would be

    http://localhost:81/soccerswap/public/

    Basically incase the port was change, URL is

    http://localhost:(YOUR-PORT-NUMBER)/soccerswap/public/

    HAVE FUN WITH SOCCER_SWAP APP.

    
    




