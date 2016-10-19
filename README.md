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

