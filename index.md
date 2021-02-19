DIAMONDPHP
==========
DiamondPHP is a fully featured web development framework built for PHP 8 and offers extreme performance, a modular architecture, elegant syntax and an easy to use philosophy.

### PROJECT STATUS
DiamondPHP is currently in **BETA** stages of development. As such, it is not recommended to use the framework in a production environment yet - there are still bugs needing fixed and a few more features to be added.
A production-ready version 1.0.0 is scheduled for public release on March 31, 2021.

### PHILOSOPHY & GOALS
Like all frameworks, DiamondPHP strives to simplify and speed up the web development process. Where DiamondPHP deviates from most frameworks
is in its emphasis on the *developer*, by creating an extraordinarily easy to learn and easy to use environment -- without sacrificing performance,
features or extensibility. A framework should help a developer by completing common tasks for the developer and providing options for other tasks,
but still being perfectly capable of "getting out of the way" when needed. A framework cannot be all things to all people, so it is important to be
able to *safely* work outside the box with minimal fuss when needed.
We think that you'll find the blazing fast performance, the ultra-light footprint, the comprehensive feature set and the emphasis on ease of use 
to be an indispensable new tool in your web development repertoire.

### FEATURES
* PHP 8.0 compliant
* MVC architecture
* Pimple Dependency Injection
* Composer package management
* Symfony observer/event dispatching
* Smarty 3 template engine
* Large collection of custom developer tools (Geolocation, cronjob management, IP white & black listing, text/date/time formatting, and much more)
* Built-in login system & session management

### Documentation
Full and comprehensive documentation is currently in development, and is packaged along with the framework. Once the framework is installed, visit http://yoursite.com/documentation.
Documentation is also available online at https://diamondphp.org/documentation

### Requirements
- Apache Server 2.4+
- PHP 8.0 or newer
- Any PDO compatible database
- Composer package manager (https://getcomposer.org/)
- SSH access to your server (optional, but recommended)

### Installation
2. Unpack the diamondphp-master zip file in your installation directory. Using command prompt (Windows) or terminal (OS X / Linux), navigate to the directory where you unpacked the framework. 
Example: ** cd /var/www/html ** 
Using Composer, run the command ** 'composer update' **. Get Composer here if you do not already have Composer installed (Composer is required in order to use the framework, and to keep everything up to date): https://getcomposer.org/download/
3. Locate the ** .env.example ** configuration file in the root of your installation directory. Rename the .env.example file to .env
4. Enter your database connection settings on lines 4 - 7
5. Enter your full site URL on line 22 **[site_url=""]**, including protocol (http / https), and append a trailing slash at the end
   *http://www.example.com/*
6. Edit your timezone, if applicable, on line 32.

That's it! If you are installing the framework into a subdirectory, you'll have one more step to complete:

##### IF YOU ARE INSTALLING IN A SUBDIRECTORY
To complete installation in subdirectory, you will need to also update the RewriteBase rule in the provided .htaccess file in the root directory.  Change `RewriteBase /` to `RewriteBase /name-of-your-subdirectory/`

The remaining settings are optional to complete, and are discussed in more detail in the documentation. Feel free to go through them and add/edit as necessary.
