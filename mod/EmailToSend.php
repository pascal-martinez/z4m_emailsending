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
 * ZnetDK 4 Mobile Email Sending module class
 * 
 * File version: 1.0
 * Last update: 05/17/2024
 */

namespace z4m_emailsending\mod;

use PHPMailer\PHPMailer\PHPMailer;

require_once ('PHPMailer'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'PHPMailer.php');
require_once ('PHPMailer'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Exception.php');
require_once ('PHPMailer'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'SMTP.php');

/**
 * Class used to send an email via PHPMailer.
 * Server settings are made through the EmailServerSettings class.
 * Email subject and body can be set from a template.
 * Supported ZnetDK version: 2.9 or higher.
 */
class EmailToSend extends PHPMailer {
    private $isSendindEnabled = FALSE;
    private $isHistoryEnabled = FALSE;
    
    /**
     * Folder where are located images to embed within email body. 
     * @var string Base directory expected by the PHPMailer::msgHTML() method
     * for the $baseDir argument. 
     */
    protected $imageBaseDir = ZNETDK_APP_ROOT . '/public/images';
    
    /**
     * Business reference in email sending history
     * @var string
     */
    public $businessReference = NULL;
    
    /**
     * Instantiates a new email to send
     */
    public function __construct() {
        parent::__construct(FALSE); // No exception
        $this->CharSet = self::CHARSET_UTF8;
        $this->setLanguage(\UserSession::getLanguage(),
                ZNETDK_MOD_ROOT . '/z4m_emailsending/mod/PHPMailer/language/');
        $this->initServerSettings();
    }
    
    /**
     * Initializes the Server settings required to send email.
     */
    protected function initServerSettings() {
        $settings = new EmailServerSettings();
        $this->isHistoryEnabled = $settings->isHistoryEnabled();
        $this->isSendindEnabled = $settings->isSendingEnabled();
        if ($settings->sender_email !== '' && $settings->sender_name !== '') {
            $this->setFrom($settings->sender_email, $settings->sender_name);
        }
        if ($settings->isSMTP()) {
            $this->isSMTP();
            $this->Host       = $settings->host;
            $this->Port       = $settings->port;
            $this->SMTPAuth   = $settings->auth === '1';
            if (is_string($settings->security) && $settings->security !== '') {
                $this->SMTPSecure = $settings->security;
            }
            if ($settings->isSMTP(TRUE)) {
                $this->Username = $settings->username;
                $this->Password = $settings->password;
            }
            if ($settings->isSMTPDebugEnabled()) {
                $this->enableSMTPDebugging();
            }
        } else {
            $this->isMail();
        }
    }
    
    /**
     * Enables SMTP debugging.
     * Traces are written within the 'engine/log/emails_sent.log' file.
     */
    protected function enableSMTPDebugging() {
        $this->SMTPDebug = MOD_Z4M_EMAILSENDING_SMTP_DEBUG_LEVEL;
        $this->Debugoutput = function($msg, $level) {
            $logFile = ZNETDK_ROOT . 'engine'. DIRECTORY_SEPARATOR
                    . 'log' . DIRECTORY_SEPARATOR . 'emails_sent.log';
            $currentDate = '[' . date("Y-m-d H:i:s") . '] ';
            $logEntry = $currentDate . 'z4m_emailsending('.$level.')' 
                    . ' - ' . $msg . PHP_EOL;
            file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
        };
    }
    
    /**
     * If no sender is set for the email (From property), a default sender is
     * set from the logged in user email and name if CFG_AUTHENT_REQUIRED is
     * TRUE. 
     */
    protected function setDefaultSender() {
        If ($this->From === '' && CFG_AUTHENT_REQUIRED === TRUE) {
            $this->setFrom(\UserSession::getUserEmail(), \UserSession::getUserName());
        }
    }
    
    /**
     * Sets a custom base directory where are located images to embed within 
     * the email body.
     * @param string $baseDir Absolute base directory path.
     */
    public function setImageBaseDir($baseDir) {
        $this->templateImageBaseDir = $baseDir;
    }
    
    /**
     * Uses the specified email template to initialize the 'Subject' and
     * 'Body' properties. The email template must be located in the 'email'
     * subfolder of the application, of a custom module or this module itself.
     * The email template with the language code as suffix in its name is
     * searched first, from the current language set for the connected user.
     * @param string $templateName Template name of the email, optionnaly
     * prefixed by the module name where the template is localized
     * (i.e 'module:template').
     * @param array|NULL $subjectValues Optional, values to set within the email
     * template subject.
     * @param array|NULL $bodyValues Optional, values to set within the email
     * template body.
     * @param array|NULL $sensitiveValues Optional, sensitive values to hide
     * if the email body is stored in email sending history.
     * @throws \ZDKException Thrown if the template does not exist or is not
     * properly defined.
     */
    public function useTemplate($templateName, $subjectValues = NULL,
            $bodyValues = NULL, $sensitiveValues = NULL) {
        $template = new EmailTemplate($templateName, $this->FromName);
        if (!is_null($subjectValues)) {
            $template->setSubjectValues($subjectValues, $sensitiveValues);
        }
        if (!is_null($bodyValues)) {
            $template->setBodyValues($bodyValues, $sensitiveValues);
        }
        $templateImageBaseDir = $template->getImageBaseDir();
        if (is_null($templateImageBaseDir)) {
            $templateImageBaseDir = $this->imageBaseDir;
        }
        $this->Subject = $template->getSubject();
        $this->msgHTML($template->getBody(), $templateImageBaseDir);
    }

    /**
     * Overloads the PHPMailer::msgHTML() method.
     * If $basedir is not specified, its value is set from the
     * EmailToSend::imageBaseDir property (default value is 
     * '../default/app/public/images/') that can be customized via the
     * EmailToSend::setImageBaseDir() method.
     * @param string $message See PHPMailer::msgHTML() method.
     * @param string $basedir See PHPMailer::msgHTML() method.
     * @param bool|callable $advanced See PHPMailer::msgHTML() method.
     */
    public function msgHTML($message, $basedir = '', $advanced = false) {
        if ($basedir === '') {
            $basedir = $this->imageBaseDir;
        }
        parent::msgHTML($message, $basedir, $advanced);
    }
    
    /**
     * Overloads the PHPMailer:send() method.
     * - The email is not sent if email sending is disabled (see 
     * EmailServerSettings class).
     * - The email data is historicized if email sending history is enabled (see
     * EmailServerSettings class).
     * - if no sender is specified for the email, the sender is set from the
     * logged in user email and name if CFG_AUTHENT_REQUIRED is TRUE. 
     * @throws \ZDKException Email sending failed or disabled.
     */
    public function send() {
        $errorMessage = NULL;
        $status = FALSE;
        $this->setDefaultSender();
        if ($this->isSendindEnabled) {
            $status = parent::send();
            $errorMessage = !$status ? $this->ErrorInfo : NULL;
        } else {
            $errorMessage = 'Email sending disabled';// TODO (localized message)
        }
        if ($this->isHistoryEnabled) {
            EmailSendingHistory::add($this, $status, $errorMessage);
        }
        if (!$status) {
            $errorNumber = $this->isSendindEnabled ? '001' : '002';
            throw new \ZDKException("ETS-{$errorNumber}: {$errorMessage}");
        }
    }
}
