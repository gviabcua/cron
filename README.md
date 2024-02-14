##Features
My powerful workflow plugin allows you to perform predefined tasks that are triggered by cronjobs or events.

##Examples
- Send a customized email a day before (or a day after) the arrival of guests (**cronjob > email**)
- Ping URL (e.g. on IFTTT) after an online payment (**event > ping**)
- Update a record in the database

##Workflows
Workflows are sets of **actions** (send mails, ping URL's) that are started by a **trigger** (inside your own code, by an event or from a cronjob).

Workflows have CamelCase names.

##Triggers
Triggers are used to start rules and have a **type** (manual, event, cronjob) and a **value**. Triggers can be re-used.

###Manual trigger
You can call any trigger like this:

    use Briddle\Workflow\Models\Workflow;
    $workflow = New Workflow;
    $workflow->triggerWorkflow('CamelCasedWorkflowName');

###Event trigger
The **event** trigger type accepts the name of the event (e.g. `rainlab.user.register`).

###Cronjob trigger
> Using this trigger type requires setting up the scheduler.

The **cronjob** trigger type accepts values in standard crontab syntax (e.g. *****). 

1. Entry: **Minute** when the process will be started [0-60 or *]
2. Entry: **Hour** when the process will be started [0-23 or *]
3. Entry: **Day of the month** when the process will be started [1-28/29/30/31 or *]
4. Entry: **Month of the year** when the process will be started [1-12 or *]
5. Entry: **Weekday** when the process will be started [0-6 or *] (0 is Sunday)
 
For scheduled tasks to operate correctly, you should add the following Cron entry to your server.

    php -q /path/to/artisan schedule:run >> /dev/null 2>&1


##Actions
Actions are used to perform tasks and have a **type** and a **value**. Actions can be re-used.

Actions have lowercase names.

###Mail action
The **mail** action type accepts any raw SQL query that returns at least a name and email address. In the case of mailings the identification code for the action also corresponds to the code for a mail template. The database record will be available within the mail template (e.g. `{{ name }}`).

###Webhook action
The **webhook** action type accepts any full URL.

###Log action
The **log** action type accepts any value.

###Query action
The **query** action type accepts any raw SQL query.

##Examples
To **email** admins if they are inactive for more then a week:
1. Create a trigger of type **cronjob** and specify a **value** for the cronjob
2. Create an action of type **mail** and make sure you setup a mail template using the identification code of the action.
3. The Action value is a query that should return an array of objects and has to include the properties **email** and **name** (as they will be used for sending the mails). This array is also available in the mail template.

    `SELECT email as email, first_name as name FROM backend_users WHERE is_activated=1 AND last_login < DATE_SUB(NOW(), INTERVAL 1 day)`
    
To **ping a URL** (e.g. after making a payment)
1. Create a trigger of type **manual**
2. Create an action of type **webhook**
3. The Action value is the URL you want to ping (e.g. `https://mysite.com/webhook`)
4. Call the trigger in your own code (e.g. within the onStart() function in the code section of a page)
 
Send an email (e.g. when a new user registers)
1. Create a trigger of type **event** and specify a **value** for it (e.g. rainlab.user.register)
2. Create an action of type **mail** and make sure you setup a mail template using the identification code of the action.
3. The Action value is a query that should return an array of objects and has to include the properties **email** and **name** (as they will be used for sending the mails). This array is also available in the mail template.

To **ping a URL** (e.g. after registration)
1. Create a trigger of type **event** and specify a **value** for it (e.g. rainlab.user.register)
2. Create an action of type **webhook** 
3. The Action value is the URL you want to ping (e.g. a webhook at IFTTT.com) 


##Permissions
As always you can set permissions for this plugin in **Settings > Administrators**