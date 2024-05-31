<?php
/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://mobile.znetdk.fr
 * Copyright (C) 2024 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL https://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * --------------------------------------------------------------------
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK 4 Mobile Email Sending module server settings class
 * 
 * File version: 1.0
 * Last update: 05/21/2024
 */
namespace z4m_emailsending\mod;

require_once('PHPMailer'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'PHPMailer.php');
require_once('PHPMailer'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Exception.php');
require_once('PHPMailer'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'SMTP.php');

use PHPMailer\PHPMailer\SMTP;
use z4m_emailsending\mod\validator\SettingsValidator;

/**
 * Configuration of the email sending settings.
 * This class is used by a \z4m_email\mod\Email object to get email sending
 * settings.
 * Supported ZnetDK version: 2.9 or higher.
 * 
 * USAGE
 * -----------------------------------------------------------------------------
 * EXAMPLE 1: configures email sending by a local mail server.
 *   $settings = new \z4m_emailsending\mod\EmailServerSettings();
 *   $settings->setLocal();
 *   $settings->store();
 * 
 * EXAMPLE 2: configures email sending by a remote SMTP server.
 *   $settings = new \z4m_emailsending\mod\EmailServerSettings();
 *   $settings->setSMTP('smtp.example.com', 465, true, 'user@example.com', 
 *      'secret', 'ssl');
 *   $settings->store();
 * 
 * EXAMPLE 3: getting SMTP settings
 *   $settings = new \z4m_emailsending\mod\EmailServerSettings();
 *   $isSMTP = $settings->isSMTP();
 *   if ($isSMTP) {
 *      $host = $settings->host;
 *      $auth = $settings->auth;
 *      $username = $settings->username;
 *      $password = $settings->password;
 *      $security = $settings->security;
 *      $port = $settings->security;
 *      $debug = $settings->isSMTPDebugEnabled();
 *      $sending = $settings->isSendingEnabled();
 *      $history = $settings->isHistoryEnabled();
 *      $senderName = $settings->sender_name;
 *      $senderEmail = $settings->sender_email;
 *   }    
 */
class EmailServerSettings {
    
    protected $settings = NULL;
    /**
     * Instantiates new Email sending server settings object.
     * @param boolean $initFromHttpRequest Should we initialize the parameters
     * from the HTTP request POST values? If FALSE, settings are read from the
     * database, otherwise settings are set from the current HTTP request POST
     * parameters.
     */
    public function __construct($initFromHttpRequest = FALSE) {
        if ($initFromHttpRequest) {
            $this->initFromHttpRequest();
        } else {
            $this->fetchData();
        }
    }
    /**
     * Initializes the settings from the current HTTP request POST values.
     */
    protected function initFromHttpRequest() {
        $request = new \Request();
        $this->settings = $request->getValuesAsMap('is_smtp',
            'is_sending_enabled', 'host', 'port', 'auth', 'username',
            'password', 'security', 'is_history_enabled', 'is_debug_enabled',
            'sender_name', 'sender_email');
        $this->settings['id'] = 1;
        if ($this->settings['is_smtp'] === '0') {
            $this->settings['host'] = NULL;
            $this->settings['port'] = NULL;
            $this->settings['auth'] = NULL;
        }
        if ($this->settings['is_smtp'] === '0' || is_null($this->settings['auth'])) {
            $this->settings['username'] = NULL;
            $this->settings['password'] = NULL;
        }
    }
    
    /**
     * Validates settings data.
     * @param boolean $throwException If TRUE, an exception is triggered if
     * validation failed.
     * @return TRUE|array TRUE if validation has succeeded otherwise
     * informations about failed validation (keys are 'message' and 'property').
     * @throws \ZDKException Validation error if $throwException is TRUE.
     */
    public function validate($throwException = FALSE) {
        $validator = new SettingsValidator();
        $validator->setValues($this->settings);
        $validator->setCheckingMissingValues();
        if (!$validator->validate()) {
            $property = $validator->getErrorVariable();
            $error = $validator->getErrorMessage();
            if ($throwException) {
                throw new \ZDKException("ESS-001: [{$property}] {$error}");
            }
            return ['message' => $error, 'property' => $property];
        }
        return TRUE;
    }
    
    /**
     * Fetches email sending server settings 
     */
    protected function fetchData() {
        $dao = new model\ServerSettingsDAO();
        $this->createModuleSqlTable($dao);
        $row = $dao->getById(1);
        if (is_array($row)) {
            $this->settings = $row;
            $this->decrypt();
        } else { // SQL table is empty...
            throw new \ZDKException('ESS-002: no settings found in database.');
        }
    }
    
    /**
     * Returns the property value.
     * @param type $property
     * @return string The value matching the specified property
     * @throws \ZDKException Unknown property
     */
    public function __get($property) {
        if (key_exists($property, $this->settings)) {
            return $this->settings[$property];
        }
        throw new \ZDKException("ESS-003: unknown property '{$property}'.");
    }
    
    /**
     * Returns settings as a database row.
     * @return array Settings as database row.
     */
    public function getRow() {
        return $this->settings;
    }
        
    /**
     * Indicates whether the configured server is SMTP.
     * @param type $withAuth If TRUE, checks if authentication is enabled.
     * @return boolean Value TRUE if SMTP server is configured
     */    
    public function isSMTP($withAuth = FALSE) {
        if ($this->settings['is_smtp'] === '0') {
            return FALSE;
        }
        return $withAuth ? $this->settings['auth'] === '1' : TRUE;
    }
    
    /**
     * Indicates whether SMTP debugging is enabled.
     * @return boolean TRUE if SMTP debugging is enabled.
     */
    public function isSMTPDebugEnabled() {
        return $this->settings['is_debug_enabled'] === '1';
    }
    
    /**
     * Indicates whether sent emails are historicized or not
     * @return boolean TRUE if email sending history is enabled.
     */
    public function isHistoryEnabled() {
        return $this->settings['is_history_enabled'] === '1';
    }
    
    /**
     * Indicates whether email sending is enabled or not
     * @return boolean TRUE if email sending is enabled.
     */
    public function isSendingEnabled() {
        return $this->settings['is_sending_enabled'] === '1';
    }
    
    /**
     * Configures local server to send emails
     */
    public function setLocal() {
        $this->settings['is_smtp'] = '0';
    }
    
    /**
     * Configures SMTP server to send emails
     * @param string $host SMTP server host name or IP address.
     * @param integer $port TCP/IP port number
     * @param boolean $auth If TRUE, authentication to SMTP server is required.
     * @param string|NULL $username Optional if $auth is FALSE, User name for
     * authentication to the SMTP server.
     * @param string|NULL $password Optional if $auth is FALSE, Server 
     * authentication password.
     * @param string|NULL $security Optional, value 'ssl' or 'tls'.
     * @param boolean $debug If TRUE, SMTP debugging is enabled (client and
     *  server messages).
     */
    public function setSMTP($host, $port, $auth, $username = NULL,
            $password = NULL, $security = NULL, $debug = FALSE) {
        if ($auth === TRUE && is_null($username)) {
            throw new \ZDKException('ESS-004: Username is mandatory.');
        } 
        if ($auth === TRUE && is_null($password)) {
            throw new \ZDKException('ESS-005: Password is mandatory.');
        }
        $this->settings['is_smtp'] = '1';
        $this->settings['host'] = $host;
        $this->settings['auth'] = $auth;
        $this->settings['username'] = $username;
        $this->settings['password'] = $password;
        $this->settings['security'] = $security;
        $this->settings['port'] = $port;
        $this->settings['is_debug_enabled'] = $debug;
    }
    
    /**
     * Checks if the encryption key is set in the 'config.php' file of the APP
     * via the MOD_Z4M_EMAILSENDING_ENCRYPTION_KEY PHP constant.
     * @throws \ZDKException Encryption key not defined.
     */
    protected function checkEncryptionKeySet() {
        if (MOD_Z4M_EMAILSENDING_ENCRYPTION_KEY === NULL) {
            throw new \ZDKException('ESS-006: MOD_Z4M_EMAILSENDING_ENCRYPTION_KEY constant not set within the APP config.php.');
        }
    }
    
    /**
     * Encrypts the SMTP username and password.
     */
    protected function encrypt() {
        if (!$this->isSMTP(TRUE)) {
            return;
        }
        $this->checkEncryptionKeySet();
        $this->settings['username'] = \General::encrypt(
            $this->settings['username'], MOD_Z4M_EMAILSENDING_ENCRYPTION_KEY);
        $this->settings['password'] = \General::encrypt(
            $this->settings['password'], MOD_Z4M_EMAILSENDING_ENCRYPTION_KEY);
    }
    
    /**
     * Decrypts the SMTP username and password.
     */
    protected function decrypt() {
        if (!$this->isSMTP(TRUE)) {
            return;
        }
        $this->checkEncryptionKeySet();
        $this->settings['username'] = \General::decrypt(
            $this->settings['username'], MOD_Z4M_EMAILSENDING_ENCRYPTION_KEY);
        $this->settings['password'] = \General::decrypt(
            $this->settings['password'], MOD_Z4M_EMAILSENDING_ENCRYPTION_KEY);
    }
    
    /**
     * Stores the settings
     * @param boolean $autocommit If FALSE, a SQL transaction must be started
     * before calling this method.
     */
    public function store($autocommit = TRUE) {
        $dao = new model\ServerSettingsDAO();
        $this->encrypt();
        $dao->store($this->settings, $autocommit);
    }
    
    /**
     * Checks connection to the SMTP Server
     * @return boolean TRUE on success.
     * @throws \ZDKException Not configured as SMTP, connection failed, EHLO
     * failed, encryption failed, authentication failed.
     */
    public function checkSMTPConnection() {
        if (!$this->isSMTP()) {
            throw new \ZDKException('ESS-007: sending is not configured for SMTP server.');
        }
        date_default_timezone_set('Etc/UTC');
        //Create a new SMTP instance
        $smtp = new SMTP();
        //Enable connection-level debug output
        $smtp->do_debug = SMTP::DEBUG_OFF;
        //Connect to an SMTP server
        if (!$smtp->connect($this->host, $this->port)) {
            throw new \ZDKException('ESS-008: Connection failed.');
        }
        //Say hello
        if (!$smtp->hello(gethostname())) {
            throw new \ZDKException('ESS-009: EHLO failed: ' . $smtp->getError()['error']);
        }
        //Get the list of ESMTP services the server offers
        $e = $smtp->getServerExtList();
        //If server can do TLS encryption, use it
        if ($this->security === 'tls' && is_array($e) && array_key_exists('STARTTLS', $e)) {
            $tlsok = $smtp->startTLS();
            if (!$tlsok) {
                throw new \ZDKException('ESS-010: Failed to start encryption: ' . $smtp->getError()['error']);
            }
            //Repeat EHLO after STARTTLS
            if (!$smtp->hello(gethostname())) {
                throw new \ZDKException('ESS-011: EHLO (2) failed: ' . $smtp->getError()['error']);
            }
            //Get new capabilities list, which will usually now include AUTH if it didn't before
            $e = $smtp->getServerExtList();
        }
        //If server supports authentication, do it (even if no encryption)
        if ($this->auth === '1' && is_array($e) && array_key_exists('AUTH', $e)) {
            if (!$smtp->authenticate($this->username, $this->password)) {
                throw new \ZDKException('ESS-012: Authentication failed: ' . $smtp->getError()['error']);
            }
        }
        //Whatever happened, close the connection.
        $smtp->quit();
        return TRUE;
    }
    
    /**
     * Sends a test email to the specified recipient email address.
     * @param string $recipientEmail Recipient Email address
     */
    static public function sendTestEmail($recipientEmail) {
        $email = new EmailToSend();
        $email->Timeout = 15;
        $email->useTemplate('test-email', ['**application_name**' => NULL],
            ['**sender_name**' => NULL]);
        $email->addAddress($recipientEmail);
        $attachmentPath = ZNETDK_ROOT . 'engine/public/images/logoznetdk.png';
        if (file_exists($attachmentPath)) {
            $email->addAttachment($attachmentPath);
        }
        $email->businessReference = "test-email";
        $email->send();
    }
    
    /**
     * Create the SQL table required for the module.
     * The table is created from the SQL script defined via the
     * MOD_Z4M_EMAILSENDING_SQL_SCRIPT_PATH constant.
     * @param DAO $dao DAO for which existence is checked
     * @throws \Exception SQL script is missing and SQL table creation failed.
     */
    static public function createModuleSqlTable($dao) {
        if ($dao->doesTableExist()) {
            return;
        }
        if (!file_exists(MOD_Z4M_EMAILSENDING_SQL_SCRIPT_PATH)) {
            $error = "SQL script '" . MOD_Z4M_EMAILSENDING_SQL_SCRIPT_PATH . "' is missing.";
            throw new \Exception($error);
        }
        $sqlScript = file_get_contents(MOD_Z4M_EMAILSENDING_SQL_SCRIPT_PATH);
        $db = \Database::getApplDbConnection();
        try {
            $db->exec($sqlScript);
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            throw new \Exception("Error executing 'z4m_emailsending' module SQL script.");
        }
        
    }
    
}
