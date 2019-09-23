## About Lucky Draw

Lucky Draw is an application which demonstrates a few of the laravel functionalities

It is required that you download and install laravel as per [this](https://laravel.com/docs/6.x). Also you must have Mysql 8.0 installed.

## Mysql 8.x Special Care
Please run the following statements one by one for Mysql 8.0 or else you are likely to get this [error](https://ma.ttias.be/mysql-8-laravel-the-server-requested-authentication-method-unknown-to-the-client/)
```
CREATE USER 'admin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'admin';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost' WITH GRANT OPTION;
CREATE USER 'admin'@'%' IDENTIFIED WITH mysql_native_password BY 'admin';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%' WITH GRANT OPTION;
#
CREATE DATABASE IF NOT EXISTS `draw` COLLATE 'utf8_general_ci' ;
GRANT ALL ON `draw`.* TO 'admin'@'%' ;
FLUSH PRIVILEGES ;
```

## Installation
`git clone git@github.com:somiithm/draw.git`
`cd draw`

Copy example env into .env<br/>
`cp .env.example .env`

Install dependencies<br/>
`composer install`

Migrate and seed with lottery users<br/>
`php artisan migrate:refresh --seed`

`php artisan serve`

Post this go to localhost:8000/home to start your lucky draw admin experience

## Algorithm
```
if( generation == random) {
    if(prize == grand prize){
        select users with maximum numbers.
        randomly select one number among them.
    } else {
        get all numbers from all users
        randomly select one number among them
    }
} else {
    select users with given number in their list.
    randomly select one user as winner for the given prize
    if no users have the number return error
}
```

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

