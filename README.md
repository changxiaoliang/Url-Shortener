# Url-Shortener
URL shortener in PHP - Generation of static or temporary short links that expire on time duration/number of clicks


Requirements:
- Apache2 Server (or Nginx)
- Php 7.x
- Maria-db or Mysql Server


Installation:
1) create a database named "sht" in your  mysql/mariadb with the command the
database cli interface:
create database sht;
2) copy/paste the content of the file create_tables.sql in the cli interface
of the database to create the required table and index;
3)copy index.php and logo.png in the folder of your web server, usually
/var/www/html/;
4) edit index.php and set the correct user and password to access the
/database (line 3);


Running:
Open with the browser your web server, the user interface should be shown.

Errors Solution:
Check the logs of the web server.


For any help, please send an email to: samuele@landi.ae

