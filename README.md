# Coding with Quality
A login module - created for a course called 'Introduction to software quality'.

### What is implemented?
This module currently contains basic registration and a simple login.

### What is not implemented?
Extremely insecure - should not be used in production.

* The passwords are not hashed.
* Cookie manipulation login is possible.
* Session hijacking is possible.
* Username and Password are stored in cookies.

### Before using
**IMPORTANT**: Make the file in the database folder inaccessible for the user.

If you're using apache/2, this file can be hidden by adding the following to the related **.conf** file located here: **/etc/apache2/sites-available**.

    <Directory /var/www/{webpage folder}/database/>
        Options -Indexes
        Order deny,allow
        deny from all
    </Directory>


### Requirements
* Php ^7.0.*

Install php-7.0 on Linux with the following command:

    apt-get install php7.0

### How to start?
Start by writing the following:

    php -S localhost:port

### How to test?
The module can be tested here:
[Test Application](http://csquiz.lnu.se:82/).

An example of a test:

![test example](/example-test.png)

### Live Application
A live version of the module can be found here: [Live](http://final.dwow.se/).
