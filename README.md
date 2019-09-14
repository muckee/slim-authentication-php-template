# slim-php-template

A template repository for composer projects utilising Slim PHP Framework version 4.

## Getting Started

These instructions will help you to install and configure the template in a development environment. The application is not suitable for deployment in a production environment and should be used for educational, development and testing purposes only.

#### Pre-requisites

Nginx and the most recent version of PHP should be installed on the host system. In Ubuntu this can be achieved using the following code:

```
# apt install nginx php php-common php-fpm
```

An nginx vhost file should be created for the application. In ubuntu the path for the default vhost configuration is `etc/nginx/sites-available/default`. This file can be duplicated, allowing you to create your own vhost configuration. Alternatively, you can copy the following configuration and place it in the file `/etc/nginx/sites-available/example.domain.com`:

```
server {
    listen 80;
    server_name example.domain.com;
    root /var/www/example.domain.com/public_html/;

    index index.php index.html index.htm;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /var/log/nginx/example.domain.com-error.log error;

    sendfile off;

    client_max_body_size 100m;

    location ~ \.php$ {
      root /var/www/example.domain.com/public_html/;
      fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
      fastcgi_index index.php;
      include fastcgi_params;
      fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

The `server_name` parameter should be set to the desired domain name. The `root` parameters should both be set to the public root of the application - be sure to retain the trailing slashes. The `error_log` parameter should be altered to ensure that the error file's name contains the application's real domain name.
If you receive errors detailing that php-fpm is not installed or cannot be located, but you have ensured that it is properly installed and working, then run the command `$ locate php7.2-fpm.sock` in your server's console and ensure that the `fastcgi_pass` parameter's value is equal to the response.

### Installation

When you are ready to test out the application then the following commands can be issued. The first command disables the default virtual host, the second command enables the newly-created virtual host configuration and the third/fourth commands restart the nginx and php-fpm services to ensure that the new configuration is loaded.

```
# rm /etc/nginx/sites-enabled/default
# ln -sf /etc/nginx/sites-available/example.domain.com /etc/nginx/sites-enabled/
# systemctl restart nginx
# systemctl restart php-fpm
```
End with an example of getting some data out of the system or using it for a little demo

## Running the tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* Lots
* of
* things

## Authors

* **Joshua Flood** - *Initial work* - [Joshua Flood](http://joshuaflood.co.uk)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone whose code was used
* Inspiration
* etc
