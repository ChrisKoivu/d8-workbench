This is my basic setup branch for Drupal 8. It is built on version 8.8.

For local development in Windows, Use WAMPServer. There is an issue where 
the site shuts down as the db connection breaks due to the packet size. 
This can be fixed by changing a setting in the my.ini file in the MariaDB 
settings. 

Update the max allowed packet line as shown below:

max_allowed_packet = 64M

Update the php.ini file as follows:
 memory_limit = 512M
