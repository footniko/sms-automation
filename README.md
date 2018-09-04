Laravel SMS Automation Application
==================================

This is the SMS Automation web application written on Laravel.  

Overview
--------

This application consists of a few REST API endpoints:  

- **/campaigns**  
Retrieves/creates an sms campaign with given phone numbers.  
Request `GET /campaigns`  
Response:  
```
{
    "data": [
        {
            "id": 1,
            "title": "Test campaign",
            "message": "Some random message",
            "receivers": "+380988984390;+380980313660",
            "status": "Sent",
            "created_at": "2018-09-04 08:48:34"
        },
        {
            "id": 2,
            "title": "Test campaign",
            "message": "Some random message",
            "receivers": "+380988984390;+380980313660",
            "status": "Sent",
            "created_at": "2018-09-04 10:20:17"
        }
    ]
}
```
Request `POST /campaigns`
```
{
    "title": "Test campaign",
    "message": "Some random message",
    "receivers": ["+380988984390","+380980313660"]
}
```
Response:
```
{
    "data": {
        "id": 3,
        "title": "Test campaign",
        "message": "Some random message",
        "receivers": "+380988984390;+380980313660",
        "status": "Active",
        "created_at": "2018-09-04 10:44:43"
    }
}
```
  
In order to launch this application, you need to have a configured web server with database.  
You need to fill out `.env` file as described in `.env.example` with your configs.  

This app also supports a command that sends all queued sms messages to its receivers. In order to run it, you have to run the following command:
```
php /path/to/project/root/artisan sms:send
```
This command will retrieve a list of queued sms messages from database limited by `APP_MESSAGES_LIMIT` config param and send them to the recipients. Logs will be stored at `sms_logs` table.  
You can configure your system to schedule this command (using cron for example).
