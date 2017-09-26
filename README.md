## Composer Setup ##
To run this project, you'll need:

* PHP 5.4 or greater with the command-line interface (CLI) and JSON extension installed.
* The Composer(<https://getcomposer.org/>) dependency management tool.
  * Installing composer
    * Linux & Mac:
	```curl -sS [https://getcomposer.org/installer](https://getcomposer.org/installer) | php```
    * Windows installer:
	* Visit <https://getcomposer.org/download/> and download the Composer-Setup.exe
  
* Access to the internet and a web browser.
* A Google account.


## Setup the Application ##
### Step-1 ###
* Go to the Google APIs Console (<https://console.developers.google.com/>).
* Create a new project.
* Click Enable API. Search for and enable the Google Drive API.
* Create credentials for a Web Server to access Application Data.
* Name the service account and grant it a Project Role of Editor.
* Download the JSON file.
* Copy the JSON file to your app directory (project_path/config/) and rename it to client_secret.json
Steps: https://www.twilio.com/blog/wp-content/uploads/2017/02/google-developer-console.gif
![alt text](https://www.twilio.com/blog/wp-content/uploads/2017/02/google-developer-console.gif)

### Step-2 ###
* Run:
	```composer install --no-dev```
* For more information <https://www.codementor.io/jadjoubran/php-tutorial-getting-started-with-composer-8sbn6fb6t>

### Step-3 ###
* Share the google sheet with the email address (from client_secret.json)
* Give write permission in "project_path/temp" folder

## More information ##
* <https://www.twilio.com/blog/2017/03/google-spreadsheets-and-php.html>
* <https://github.com/compwright/starwood-evite/tree/master/Source/vendor/asimlqt/php-google-spreadsheet-client>
