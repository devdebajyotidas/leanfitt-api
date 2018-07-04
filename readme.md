Leanfitt
==============

![PHP](https://img.shields.io/php-eye/symfony/symfony.svg)
![Laravel](https://img.shields.io/badge/laravel-v5.6-orange.svg)

Api endpoints for all devices regardless android, ios, web.

Run phpunit test by using following command.

`vendor/bin/phpunit.bat`

Local Development
--------------

You will need a `.env` file that will be ignored but used to connect to your local development database.

`.env` needs the local db credentials:

	DB_DATABASE;
	DB_USERNAME;
	DB_PASSWORD;
	DB_HOST;


..and you will need to define these:

	FCM_KEY


Note
-------------
To develop the report you must follow the workflow of the apps.If we categorize all the reports we will see 
4 types of report.

* **Grid**
This is for report like cards and add the content inside them.

* **Chart**
For all the charts report

* **Default and Element Selection**
To make a list from default list and assign them

* **Five Why Analysis**

In the api it's url contain `problem` and `reason`


Versions
--------------

The version of laravel that the latest check-in requires:

5.6 - **Laravel**

