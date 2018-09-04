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
Workflow
--------  
The project consists of 3 major tables:  
1. sms_campaigns
2. sms_queues
3. sms_logs

When you add a campaign through the `/campaigns` endpoint, it fills _sms_campaigns_ table with common data and additionally creates a record in _sms_queues_ table for each phone number that belongs to the campaign.  
Now, when you run the console command (`sms:send`), it checks the _sms_queues_ table for records with _Waiting_ status and simply sends it to the phone number. After that, the status of the record becomes _Sent_. And, if it's the last record from the campaign the corresponding campaign's status also becomes as _Sent_.

  
Setup
-----
In order to launch this application, you need to have a configured web server with database.  
You need to fill out `.env` file as described in `.env.example` with your configs.  

Before you make any test, you have to install all composer packages:
```
cd /path/to/project/root/
composer install
```
 And apply db migrations, simply run:
```
php /path/to/project/root/artisan migrate
```
This will create all necessary tables in DB. It's also possible to fill the DB with dummy data:
```
php /path/to/project/root/artisan db:seed
```
Otherwise you can use the rest endpoint (`POST /campaigns`).

This app also supports a command that sends all queued sms messages to its receivers. In order to run it, you have to execute the following command:
```
php /path/to/project/root/artisan sms:send
```
This command will retrieve a list of queued sms messages from database limited by `APP_MESSAGES_LIMIT` config param and send them to the recipients. Logs will be stored at `sms_logs` table.  
You can configure your system to schedule this command (using cron for example).

