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
 * ZnetDK 4 Mobile Email Sending module Template class
 *
 * File version: 1.1
 * Last update: 08/02/2024
 */
namespace z4m_emailsending\mod;

/**
 * Email template
 * Sets email subject and body from an email template.
 * Templates are stored within the email subfolder of the App (../app/email) or
 * a module (../mod/email).
 * Variables can be set in an Email template subject and body. These variables
 * are then replaced by the corresponding data.
 * Supported ZnetDK version: 2.9 or higher.
 */
class EmailTemplate {
    const SENSITIVE_TAG_BEGIN = '<span class="sensitive">';
    const SENSITIVE_TAG_END = '</span>';
    const APPLICATION_NAME_VAR = '**application_name**';
    const APPLICATION_URI_VAR = '**application_uri**';
    const SENDER_NAME = '**sender_name**';

    /**
     * Template name
     * @var string Name of the template.
     */
    protected $templateName = NULL;
    /**
     * Email body set by the template
     * @var string Text of the body.
     */
    protected $templateBody = NULL;
    /**
     * Email subject set by the template
     * @var string Text of the subject
     */
    protected $templateSubject = NULL;
    /**
     * Sender name used by the '**sender_name**' standard variable.
     * @var string Sender name
     */
    protected $FromName = NULL;
    /**
     * Directory where are located images to embed within email template body.
     * This directory is set in option by the email template.
     * @var string Base directory expected by the PHPMailer::msgHTML() method
     * for the $baseDir argument.
     */
    protected $imageBaseDir = NULL;

    /**
     * Instantiates a new email template
     * @param string $templateName Template name
     * @param string $emailFromName Email sender name
     */
    public function __construct($templateName, $emailFromName) {
        $this->templateName = $templateName;
        $this->FromName = $emailFromName;
        $this->initFromTemplate();
    }
    /**
     * Searchs the email template in the App and its modules to retrieve the
     * text of the subject and the body.
     * @throws \ZDKException No template found for the specified template name
     * in the constructor, the subject or body is not properly set.
     */
    protected function initFromTemplate() {
        $language = \UserSession::getLanguage();
        $templateAsArray = explode(':', $this->templateName);
        if (count($templateAsArray) === 1) {
            // The email template is located into the application or within
            // this module.
            $allEmailTemplates = array(
                'app/email/' . $templateAsArray[0] . '_' . $language . '.php',
                'app/email/' . $templateAsArray[0] . '.php',
                'z4m_emailsending/mod/email/' . $templateAsArray[0] . '_' . $language . '.php',
                'z4m_emailsending/mod/email/' . $templateAsArray[0] . '.php'
            );
        } else { // The email template is located into a module
            $allEmailTemplates = array(
                $templateAsArray[0] . '/mod/email/' . $templateAsArray[1] . '_' . $language . '.php',
                $templateAsArray[0] . '/mod/email/' . $templateAsArray[1] . '.php'
            );
        }
        $templateFound = FALSE;
        \ErrorHandler::suspend();
        foreach ($allEmailTemplates as $emailTemplate) {
            if (include $emailTemplate) {
                $templateFound = TRUE;
                break;
            }
        }
        \ErrorHandler::restart();
        if (!$templateFound) {
            throw new \ZDKException("ETL-001: the specified template '{$this->templateName}' does not exist.");
        }
        if (is_null($this->templateBody) || is_null($this->templateSubject)) {
            throw new \ZDKException("ETL-002: the specified template '{$this->templateName}' is invalid.");
        }
    }
    /**
     * Returns the value matching the template standard variable.
     * Template standard variables are:
     * '**application_name**': the application name (LC_PAGE_TITLE constant),
     * '**application_uri**': the application URL,
     * '**sender_name**':  the sender name.
     * @param string $placeholder The variable name.
     * @param string $value The value set for the variable name.
     * @return string If $placehoder matches a standard variable, the standard
     * variable value is returned. Otherwise returns $value.
     */
    protected function getStandardVariableValue($placeholder, $value) {
        $standardValues = [
            self::APPLICATION_NAME_VAR => LC_PAGE_TITLE,
            self::APPLICATION_URI_VAR => str_replace('index.php', '',
                    \General::getApplicationURI()),
            self::SENDER_NAME => $this->FromName,
        ];
        if (key_exists($placeholder, $standardValues)) {
            return $standardValues[$placeholder];
        }
        return $value;
    }
    /**
     * Sets the values to replace in the email template subject.
     * @param array $values Value to set within the template subject. Expected
     * array keys are placeholders set within the template subject.
     * For example: ['invoice_date' => '2024-05-16', 'invoice_number' => '6558']
     * if placeholders are [[invoice_date]] and [[invoice_number]].
     * @param array|NULL $sensitiveValues Optional, sensitive values to hide
     * if the email body is stored in email sending history.
     */
    public function setSubjectValues($values, $sensitiveValues = NULL) {
        foreach ($values as $placeholder => $value) {
            $this->templateSubject = $this->replacePlaceholder($this->templateSubject,
                $placeholder, $value, $sensitiveValues);
        }
    }
    /**
     * Sets the values to replace in the email template body.
     * @param array $values Value to set within the template body. Expected
     * array keys are placeholders set within the template body.
     * For example: ['invoice_date' => '2024-05-16', 'invoice_number' => '6558']
     * if placeholders are {{invoice_date}} and {{invoice_number}}.
     * @param array|NULL $sensitiveValues Optional, sensitive values to hide
     * if the email body is stored in email sending history.
     */
    public function setBodyValues($values, $sensitiveValues = NULL) {
        foreach ($values as $placeholder => $value) {
            $this->templateBody = $this->replacePlaceholder($this->templateBody,
                    $placeholder, $value, $sensitiveValues);
        }
    }

    /**
     * Replaces the placeholder (for example [[my_placeholder]]) by the value
     * within the specified text.
     * @param string $subject The text being searched and replaced on.
     * @param string $placeholder The placeholder being searched for.
     * @param string $value The replacement value that replaces found
     *  placeholders.
     * @param array|NULL $sensitiveValues Optional, sensitive values to hide
     * if the email body is stored in email sending history.
     * @return string The new text after placeholder replacement.
     */
    protected function replacePlaceholder($subject, $placeholder, $value, $sensitiveValues) {
        $currentValue = is_array($sensitiveValues) && in_array($placeholder, $sensitiveValues)
                ? self::SENSITIVE_TAG_BEGIN . $value . self::SENSITIVE_TAG_END : $value;
        $valueToReplace = $this->getStandardVariableValue($placeholder, $currentValue);
        return str_replace("[[{$placeholder}]]", strval($valueToReplace), $subject);
    }

    /**
     * Returns the text of the subject found for the template.
     * @return string The template's subject.
     */
    public function getSubject() {
        return $this->templateSubject;
    }
    /**
     * Returns the text of the body found for the template.
     * @return string The template's body.
     */
    public function getBody() {
        return $this->templateBody;
    }
    /**
     * Returns the base directory specified by the email template.
     * @return string The image base directory (see PHPMailer::msgHTML()
     *  method).
     */
    public function getImageBaseDir() {
        return $this->imageBaseDir;
    }

    /**
     * Replaces sensitive values by the specified replacement text.
     * @param string $emailText Subject or body of the email.
     * @param string $replaceText Replacement text.
     * @return string The cleaned email text.
     */
    public static function replaceSensitiveValues($emailText, $replaceText = '****') {
        $startTag = self::SENSITIVE_TAG_BEGIN;
        $endTag = self::SENSITIVE_TAG_END;
        return preg_replace("#({$startTag}).*?({$endTag})#", "$1{$replaceText}$2", $emailText);
    }
}
