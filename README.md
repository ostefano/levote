levote
======

How to deploy the application:

0) Clone the repository and point the web server to it

1) Import the SQL data into a database (example: 'kl-conf-vote')

2) Copy application/config/database.sample.php into application/config/database.php
( file application/config/database.php is already ignored on git )

3) Change the settings to match your setup

'hostname' => 'localhost',
'username' => '',
'password' => '',
'database' => '',

4) Point the web browser to the vote folder. Login with one of the 2 users from the DB

Optional:

5) Add the correct list of students in the DB
