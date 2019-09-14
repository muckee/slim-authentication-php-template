# slim-php-template

A template repository for Slim 4 PHP framework.

## Getting Started

To install and configure the application for local testing and development, use the following instructions.


### Pre-requisites
#### PHP
##### Windows
Details on installing and configuring php for windows can be found on [the PHP website](https://windows.php.net).
If you have already installed XAMP, there is no need to install PHP manually. If you use another, similar service, please check their documentation to see whether or not PHP is included.

##### Ubuntu
```
# apt install php
```

##### RHEL/CentOS
```
# yum install php
```
---
#### Git
##### Windows
Download Git from the [official Git website](https://git-scm.com/downloads)

##### Ubuntu
```
# apt install git
```

##### RHEL/CentOS
```
# yum install git
```
---
#### Composer
##### Windows
To install Composer on windows, please follow the [documentation on the official Composer website](https://getcomposer.org/doc/00-intro.md#installation-windows)

##### Ubuntu
```
# apt install composer
```

##### RHEL/CentOS
```
# yum install composer
```
## Installation

To install the application, navigate to the folder within which you wish to clone the repository and execute the following shell commands:
```
$ git clone https://github.com/JoshuaFlood/slim-php-template.git
$ cd slim-php-template
$ composer install
```
Once the application is published, visit the homepage to see the welcome message, or visit `example.domain.com/hello/[insert_your_name_here]` to see the application in action.

## Deployment

For instructions on deployment to a production environment please refer to the [official Slim PHP Framework's documentation](http://www.slimframework.com/docs/v4/), the [official Composer documentation](https://getcomposer.org/doc/) and the documentation of any third-party dependencies or frameworks included in your project. Step-by-step instruction exceeds the scope of this documentation.

## Dependencies
* [Slim PHP Framework 4](http://www.slimframework.com/) - Router framework
* [Slim PSR7](https://github.com/slimphp/Slim-Psr7) - Implementation of PSR7 standard
* [Slim PHP-View](https://github.com/slimphp/PHP-View) - PHP view renderer
* [PHP-DI](http://php-di.org/) - Dependency injection
* [Monolog](https://github.com/Seldaek/monolog) - Log management
* [PHPDotEnv](https://github.com/vlucas/phpdotenv) - Environment variable management

## Authors

* **Joshua Flood** - *Initial work* - [Joshua Flood](http://joshuaflood.co.uk)

See also the list of [contributors](https://github.com/JoshuaFlood/slim-php-template/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
