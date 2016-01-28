#Data Warehouse Project

Please note! The user_data.php and client_secrets.p12 files are not included and need and need to be added for this app to run.

Enter this command in your terminal to download and uncompress these files:
```
$ curl http://data.sq1west.com/secret-stuff.tar.gz | tar zx
```

##Instructions to recreate this project

###Google Analytics API

####PHP Client Library

To download and set up the PHP Client Library, follow Google’s Hello Analytics API PHP QuickStart Guide (for Service Accounts, not Web Apps):
https://developers.google.com/analytics/devguides/reporting/core/v3/quickstart/service-php

####Amcharts Code Template

Instead of using Google’s HelloAnalytics.php code to make API calls, you can use the more universal code example from the following Amcharts tutorial (amcharts.php was renamed app.php in the main folder of the client library):
https://www.amcharts.com/tutorials/use-amcharts-to-visualize-google-analytics-data/

####Query the Analytics data

The tutorials above don’t explain how to work with with multiple metrics and dimensions, so this is an example:

```
$results = $analytics->data_ga->get(
    'ga:' . $google_account[ 'profile' ],
    'yesterday',
    'today',
    'ga:sessions, ga:organicSearches, ga:transactions, ga:transactionRevenue,',
    array(
      'dimensions'  => 'ga:date, ga:source, ga:medium ',
      'sort'        => 'ga:date',
    )
);
```

####Google Query Explorer

You can test and construct API queries with Google’s Query Explorer:
https://ga-dev-tools.appspot.com/query-explorer/


###Amazon Web Services

####Connecting with MySQL

Follow this youtube tutorial to set up a database (RDS instance) on AWS and connect to mysql
https://www.youtube.com/watch?v=LnAvUOmH1n0

This is an example of what you would enter in your terminal to connect your AWS RDS with MySQL:
```
/Applications/MAMP/Library/bin/mysql -h your-end-point-here -u your-username-here -p your-password-here
```

####Connecting with phpMyAdmin

This blog post explains how to connect phpMyAdmin to you RDS:
http://www.tothenew.com/blog/remotely-connect-multiple-rds-instances-with-phpmyadmin/

which comes down to this:

On your computer go to the phpmyadmin folder, and its config.inc.php file.

In the config.inc.php file search here for $cfg[‘Servers’][$i]
After moving down few lines you will find a line $i++;

After the first code block add following lines.

```
$i++;

$cfg['Servers'][$i]['host'] = 'Your RDS Endpoint';
$cfg['Servers'][$i]['port'] = '3306';
$cfg['Servers'][$i]['socket'] = '';
$cfg['Servers'][$i]['connect_type'] = 'tcp';
$cfg['Servers'][$i]['extension'] = 'mysqli';
$cfg['Servers'][$i]['compress'] = TRUE;
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['user'] = 'USERNAME';
$cfg['Servers'][$i]['password'] = ‘PASSWORD’;
```

Now you can select your AWS database from a dropdown menu in phpMyAdmin.

####Connecting the Analytics API Query app to your RDS instance

In app.php (previously amcharts.php) file under session start() add this code to connect to the AWS database:

```
$server = ‘mysql:host=your-db-instance-end-point-point-here;port=3306;db=yourdbnamehere’;
$username = ‘your-username-here’;
$password = ‘your-password-here’;
$db = new PDO($server, $username, $password);
```

###Legal

Copyright (c) 2016
