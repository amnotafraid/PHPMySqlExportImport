# PHPMySqlExportImport

## Import CSV file to MySql database
Usually, you can import a CSV file using phpMyAdmin.  However, I had a big table that I wanted to import, and the import kept timing out on me.  So I wrote importCsv.php.  If you add the host, user, password and database here:
```
$mysqli = new mysqli('', // host
                     '', // user
                     '', // password
                     ''); // database
```
Then change the column names in the `$query_start` and finally change the filename here:
```
if (($handle = fopen("ZAKCNTRCTS.txt", "r" )) != FALSE) {
```
You can execute it from the command line like this:
```
php importCsv.php
```

## Export MySql query to CSV
I had a query that I could *not* get to export to a CSV file.  So, I wrote exportCsv.php.  To use it, you must add the host, user, password and database here:
```
$mysqli = new mysqli('', // host
                     '', // user
                     '', // password
```
Modify the $query to be how you want it.  Then execute the script and pipe it to the filename you want:
```
php exportCsv.php | file.csv
```
