# ZnetDK 4 Mobile module: Email sending (z4m_emailsending)
![Screenshot of the User Sent emails view provided by the ZnetDK 4 Mobile 'z4m_emailsending' module](https://mobile.znetdk.fr/applications/default/public/images/modules/z4m_emailsending/screenshot1.png?v1.3)

The **z4m_emailsending** module extends the [ZnetDK 4 Mobile](/../../../znetdk4mobile) starter application by adding the following features:
- Sends automatically an email to :
    - **New user** added to the application to communicate **their credentials**.
    - **Existing user** who requested a **new password**:
        - To **get confirmation** of the password request when the user clicked on the *Forgot password?* link,
        - To communicate their **new password** if it has been modified by the application administrator or if the user has clicked on the *Forgot password?* link.
- New views added to the application for:
    - **configuring email sending**,
    - **testing connection** to an SMTP server,
    - **sending a test email**.
    - displaying the **history of sent emails** with the ability to filter and purge content by period and sending status.

In addition, the module includes the `EmailToSend` PHP class based on the [`PHPMailer`](https://github.com/PHPMailer/PHPMailer) class and offering the following enhancements:
- Sending emails in PHP using the **email sending configuration** done from the application view provided by the module,
- Sending an email in PHP from a custom **email template**,
- Adding automatically sent emails to the **history of sent emails**.

> [!NOTE]
> This module embeds and uses [PHPMailer](https://github.com/PHPMailer/PHPMailer) version 6.9.1 to send emails.

## LICENCE
This module is published under the version 3 of GPL General Public Licence.

## FEATURES
This module contains the `z4m_email_sending_settings` and `z4m_email_sending_history`
views to declare within the [`menu.php`](/../../../znetdk4mobile/blob/master/applications/default/app/menu.php)
of the application in order to configure the Email sending and to get the history of the sent emails.  
Email sending configuration and sent emails are stored in database within the
`zdk_email_sending_server_settings` and `zdk_email_sending_history` SQL tables
created automatically on module execution.

## REQUIREMENTS
- [ZnetDK 4 Mobile](/../../../znetdk4mobile) version 2.9 or higher,
- A **MySQL** database [is configured](https://mobile.znetdk.fr/getting-started#z4m-gs-connect-config) to store the application data,
- **PHP version 7.4** or higher,
- Authentication is enabled
([`CFG_AUTHENT_REQUIRED`](https://mobile.znetdk.fr/settings#z4m-settings-auth-required)
is `TRUE` in the App's
[`config.php`](/../../../znetdk4mobile/blob/master/applications/default/app/config.php)).

## INSTALLATION
1. Add a new subdirectory named `z4m_emailsending` within the
[`./engine/modules/`](/../../../znetdk4mobile/tree/master/engine/modules/) subdirectory of your
ZnetDK 4 Mobile starter App,
2. Copy module's code in the new `./engine/modules/z4m_emailsending/` subdirectory,
or from your IDE, pull the code from this module's GitHub repository,
3. Edit the App's [`menu.php`](/../../../znetdk4mobile/blob/master/applications/default/app/menu.php)
located in the [`./applications/default/app/`](/../../../znetdk4mobile/tree/master/applications/default/app/)
subfolder and include the [`menu.inc`](mod/menu.inc) script to add menu item definition for the
`zdk_email_sending_server_settings` and `zdk_email_sending_history` views.
```php
require ZNETDK_MOD_ROOT . '/z4m_emailsending/mod/menu.inc';
```
4. Edit the App's [`config.php`](/../../../znetdk4mobile/blob/master/applications/default/app/config.php)
located in the [`./applications/default/app/`](/../../../znetdk4mobile/tree/master/applications/default/app/)
subfolder and declare the `MOD_Z4M_EMAILSENDING_ENCRYPTION_KEY` PHP constant to set a custom encryption key 
used to encrypt the SMTP server credentials stored by the module when authentication to SMTP server is required:
```php
define('MOD_Z4M_EMAILSENDING_ENCRYPTION_KEY', 'Enter here you secret key');
```
5. Go to the **Email sending config.** menu and configure your email sending server. 

## USERS GRANTED TO MODULE FEATURES
Once the **Email sending** menu item is added to the application, you can restrict 
its access via a [user profile](https://mobile.znetdk.fr/settings#z4m-settings-user-rights).  
For example:
1. Create a user profile named `Admin` from the **Authorizations | Profiles** menu,
2. Select for this new profile, the **Email sending** menu item,
3. Finally for each allowed user, add them the `Admin` profile from the
**Authorizations | Users** menu. 

## CONFIGURING EMAIL SENDING
Once the **z4m_emailsending** is installed, you have to configure your email
server from the configuration view (see first section below).
For advanced configuration, extra PHP constants have to be added to the `config.php`
of your application (see second section below).

### FROM THE CONFIGURATION VIEW OF THE APP
![Screenshot of the Email sending configuration view provided by the ZnetDK 4 Mobile 'z4m_emailsending' module](https://mobile.znetdk.fr/applications/default/public/images/modules/z4m_emailsending/screenshot2.png?v1.3)

To send your first email, you have to configure the email server by following
the procedure below:
1. Open your App and go to configuration view by clicking the **Email sending**
and **Email sending config.** menu items.
2. Fill in the configuration form:
    1. **EMAIL SENDER**: enter the name and email address of the sender used by default to send emails.   
The email sender must be configured to allow the module to automatically send emails when a new user is created,
a user's password is changed by the administrator or when a user clicks the *Forgot password?* link.
    2. **EMAIL SENDING SERVER**: indicate whether to send emails using a **Local** email server or a **SMTP** server.   
If SMTP is choosen, common SMTP Server parameters must be filled in (Host, TCP/IP port, ...).
    3. **OPTIONS**: check the sending options.   
Email sending can be disabled by checking the **Email sending enabled** option.   
To get email sending history, check the **History of sent emails** option.   
To debug SMTP sending, check the **SMTP debug enabled level 4** option
(debug traces are written in the `emails_sent.log` located in the ZnetDK 4 Mobile
[`./engine/log`](/../../../znetdk4mobile/tree/master/engine/log/) folder).
3. Click the **Save** button to store your configuration.
4. If you configured a SMTP Server connection, click the **Test connection to SMTP server** button
to check connection to the SMTP server.
5. A test email can be sent by clicking the **Send a testing email...** button and entering a recipient email address.

### FROM THE CONFIG.PHP SCRIPT OF THE APP
The following advanced configuration parameters can be set in the
[`config.php`](/../../../znetdk4mobile/blob/master/applications/default/app/config.php) script of the application.
- `MOD_Z4M_EMAILSENDING_ENCRYPTION_KEY`: this PHP constant defines the encryption key (for example the string `'My custom encryption key'`) required to store in database the SMTP Server credentials.
- `CFG_FORGOT_PASSWORD_ENABLED`: constant set to `TRUE` by default by the module.   
Change this value to `FALSE` if you want to disable the *Forgot password?* link.
- `MOD_Z4M_EMAILSENDING_NOTIFY_USER_ON_CREATION`: constant set to `TRUE` by default.   
Change this value to `FALSE` to avoid sending an email each time a user is created.
- `MOD_Z4M_EMAILSENDING_NOTIFY_USER_ON_PASSWORD_CHANGE`: constant set to `TRUE` by default.   
Change this value to `FALSE` to avoid sending an email each time a user's password is changed.
- `MOD_Z4M_EMAILSENDING_SMTP_DEBUG_LEVEL`: constant set to `4` (LOWLEVEL) by default.   
Other accepted values are `1` (CLIENT), `2`(SERVER) and `3` (CONNECTION).

## TESTING EMAIL SENDING LOCALLY
To test emails locally and thus avoid sending test emails to a real mailbox, you
can configure a local email server like [Smtp4Dev](https://github.com/rnwood/smtp4dev). 

## STANDARD EMAIL TEMPLATES
The **z4m_emailsending** module includes several standard email templates in the
[`mod/email/`](mod/email/) folder.
- `new-password_[LANG].php`: template used to send a temporary password when
a user clicked the *forgot password?* link from the login page.
- `new-user_[LANG].php`: template used to send new user's credentials.
- `password-change_[LANG].php`: template used to send the new user's password
when it has been changed from the User view.
- `password-request_[LANG].php`: template used to get confirmation after 
a new password request done by clicking the *forgot password?* link.
- `test-email_[LANG].php`: template used to test email sending when the 
  

## SENDING A CUSTOM EMAIL IN PHP
The **z4m_emailsending** module includes the [`EmailToSend`](mod/EmailToSend.php) PHP class to send an email from the PHP code of your application,
for example for an appointment reminder.   
The `EmailToSend` PHP class extends the [`PHPMailer`](https://github.com/PHPMailer/PHPMailer) class.   
When the `EmailToSend` class is instantiated, the following `PHPMailer` properties are set by default:
- **Exceptions**: `PHPMailer` Exceptions are disabled.   
Exceptions are thrown by the `EmailToSend` object if settings can't be fetched in database and when an error occurred on email sending.
- `CharSet`: set to `utf-8`.
- **Language**: set to the language configured for the ZnetDK 4 Mobile Starter App (see [`CFG_DEFAULT_LANGUAGE`](https://mobile.znetdk.fr/settings#z4m-settings-language)).
- **Server settings**: set according to the Email sending configuration done via the module's view.   
The concerned PHPMailer properties are: `From`, `FromName`, `Mailer`, `Host`, `Port`, `SMTPAuth`, `SMTPSecure`, `Username`, `Password`, `SMTPDebug` and `Debugoutput`.
- `imageBaseDir`: set to `../default/app/public/images/` (public image folder of the application).

> [!IMPORTANT]
> To get history of email sent via the `EmailToSend` PHP class, be sure to check the **History of sent emails** option from the **Email sending configuration** view.

### SENDING A SIMPLE EMAIL
Send a simple email as you would with **PHPMailer** except you don't need to specify the email
sender and the email server connection settings.

Here is a simple example below:
```php
use \z4m_emailsending\mod\EmailToSend;
$email = new EmailToSend();
$email->addAddress('johndoe@fakeemail.com', 'John DOE');
$email->Subject = 'My email subject';
$email->msgHTML('<p>Hello,</p><p>This is my first email...</p>');
$email->send();
```

### SENDING AN EMAIL FROM A CUSTOM TEMPLATE
To send an email from your custom template, first add your template in the
`./applications/default/app/email/` folder of your App. See below an example of 
custom template named `meeting-reminder.php`:

```php
/* meeting-reminder.php: meeting reminder email template */
// Email subject
$this->templateSubject = 'Appointment reminder: [[meeting_datetime]]';

// Email message body
$this->templateBody = <<<'EOT'
<p>Hello [[customer_name]],</p>
<p>This message to remind you of the date and time of your next appointment: [[meeting_datetime]]</p>
<p>Regards,</p>
EOT;
```

Next, in the PHP code for sending your email, call the [`EmailToSend::useTemplate()`](mod/EmailToSend.php) method
to specify the template name and the values to replace in the email template.   
In the example below, the specified template is `meeting-reminder` and the values
to replace in the email subject (second argument as indexed array) and in the email body (third argument as indexed array).

```php
use \z4m_emailsending\mod\EmailToSend;
$email = new EmailToSend();
$email->useTemplate('meeting-reminder', [
        'meeting_datetime' => '2024-05-30 08:30'
    ], [
        'customer_name' => 'John DOE',
        'meeting_datetime' => '2024-05-30 08:30'
    ]
);
$email->addAddress('johndoe@fakeemail.com', 'John DOE');
$email->send();
```

## TRANSLATIONS
This module is translated in **French**, **English** and **Spanish** languages.   
To translate the view labels and the standard email templates in another language or change the standard
translations, please follow the procedure below.

### VIEW LABELS
1. Copy in the clipboard the PHP constants declared within the [`locale_en.php`](mod/lang/locale_en.php) script of the module,
2. Paste them from the clipboard within the
[`locale.php`](/../../../znetdk4mobile/blob/master/applications/default/app/lang/locale.php) script of your application,   
3. Finally, translate each text associated with these PHP constants into your own language.

### STANDARD EMAIL TEMPLATES
1. Add a folder named `email` in the [`./applications/default/app/`](/../../../znetdk4mobile/tree/master/applications/default/app/) directory of your application.
2. Copy PHP scripts whose file name ends with `_en.php` (for example [`new-password_en.php`](mod/email/new-password_en.php)) and located in the [mod/email/](mod/email/) module's folder, to the `./applications/default/app/email/` folder added in step 1,
3. Rename the copied PHP scripts to remove the language indicator suffix `_en`: for example rename `new-password_en.php` to `new-password.php`.
4. Edit the PHP scripts renamed in step 3 and translate the text to your own language.
5. Now, the new email templates located in the `./applications/default/app/email/` folder are automatically used by the module to replace standard email templates.

> [!TIP]
> The procedure to translate email templates can also be used to customize a standard template available in your native language.

## INSTALLATION ISSUES
The `zdk_email_sending_server_settings` and `zdk_email_sending_history` SQL tables
are created automatically by the module when one of the module views is displayed
for the first time.  
If the MySQL user declared through the
[`CFG_SQL_APPL_USR`](https://mobile.znetdk.fr/settings#z4m-settings-db-user)
PHP constant does not have `CREATE` privilege, the module can't create the
required SQL tables.   
In this case, you can create the module's SQL tables by importing in MySQL or
phpMyAdmin the script [`z4m_emailsending.sql`](mod/sql/z4m_emailsending.sql)
provided by the module.

## CHANGE LOG
See [CHANGELOG.md](CHANGELOG.md) file.

## CONTRIBUTING
Your contribution to the **ZnetDK 4 Mobile** project is welcome. Please refer to the [CONTRIBUTING.md](https://github.com/pascal-martinez/znetdk4mobile/blob/master/CONTRIBUTING.md) file.
