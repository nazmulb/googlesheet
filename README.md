## Setup the Application ##

* Go to the Google APIs Console (<https://console.developers.google.com/>).
* Create a new project.
* Click Enable API. Search for and enable the Google Drive API.
* Create credentials for a Web Server to access Application Data.
* Name the service account and grant it a Project Role of Editor.
* Download the JSON file.
* Copy the JSON file to your app directory (project_path/config/) and rename it to client_secret.json
Steps: https://www.twilio.com/blog/wp-content/uploads/2017/02/google-developer-console.gif
![alt text](https://www.twilio.com/blog/wp-content/uploads/2017/02/google-developer-console.gif)


## Other setup ##
* Share the google sheet with the email address (from client_secret.json)
* Give write permission in "project_path/temp" folder
