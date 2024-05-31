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
 * ZnetDK 4 Mobile Email Sending module settings validator
 *
 * File version: 1.0
 * Last update: 05/20/2024
 */

namespace z4m_emailsending\mod\validator;

/**
 * Email sending settings validator
 */
class SettingsValidator extends \Validator {

    protected function initVariables() {
        return array('is_smtp', 'is_sending_enabled', 'host', 'port', 'auth',
            'username', 'password', 'security', 'is_history_enabled',
            'is_debug_enabled', 'sender_name', 'sender_email');
    }
    /**
     * Sender name is mandatory if sender email is filled in.
     * @param string $value Sender name
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_sender_name($value) {
        if ($this->getValue('sender_email') !== NULL && is_null($value)) {
            $this->setErrorMessage(\General::getFilledMessage(
                LC_MSG_ERR_MISSING_VALUE_FOR,
                MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_NAME_LABEL));
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Sender email is mandatory if sender name is filled in.
     * @param string $value Sender email
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_sender_email($value) {
        if ($this->getValue('sender_name') !== NULL && is_null($value)) {
            $this->setErrorMessage(\General::getFilledMessage(
                LC_MSG_ERR_MISSING_VALUE_FOR,
                MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_EMAIL_LABEL));
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Expected values are '0' and '1'.
     * @param string $value Is SMTP
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_is_smtp($value) {
        if ($value !== '0' && $value !== '1') {
            $this->setErrorMessage('Invalid value');
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Host name is mandatory if server is SMTP.
     * @param string $value SMTP server host name
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_host($value) {
        if ($this->getValue('is_smtp') === '1' && is_null($value)) {
            $this->setErrorMessage(\General::getFilledMessage(
                LC_MSG_ERR_MISSING_VALUE_FOR,
                MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_HOST_LABEL));
            return FALSE;
        }
        return TRUE;
    }
    /**
     * TCP/IP port is mandatory if server is SMTP.
     * @param string $value TCP/IP port (for example 25, 465, 587)
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_port($value) {
        if ($this->getValue('is_smtp') === '1' && is_null($value)) {
            $this->setErrorMessage(\General::getFilledMessage(
                LC_MSG_ERR_MISSING_VALUE_FOR,
                MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_PORT_LABEL));
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Security protocol is NULL (optional), or must be 'ssl' or 'tls'.
     * @param string $value Security protocol
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_security($value) {
        if (!is_null($value) && $value !== 'ssl' && $value !== 'tls') {
            $this->setErrorMessage('Invalid value');
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Optional, if set, must be '1'
     * @param string $value Is authentication to SMTP server enabled?
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_auth($value) {
         if (!is_null($value) && $value !== '1') {
            $this->setErrorMessage('Invalid value');
            return FALSE;
        }
        return TRUE;
    }
    /**
     * User name is mandatory if authentication is set to '1'.
     * @param string $value User account on SMTP server
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_username($value) {
        if ($this->getValue('auth') === '1' && is_null($value)) {
            $this->setErrorMessage(\General::getFilledMessage(
                LC_MSG_ERR_MISSING_VALUE_FOR,
                MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_USERNAME_LABEL));
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Password is mandatory if authentication is set to '1'.
     * @param string $value Password on SMTP server
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_password($value) {
        if ($this->getValue('auth') === '1' && is_null($value)) {
            $this->setErrorMessage(\General::getFilledMessage(
                LC_MSG_ERR_MISSING_VALUE_FOR,
                MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_PASSWORD_LABEL));
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Optional, if set, must be '1'
     * @param string $value Is email sending enabled?
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_is_sending_enabled($value) {
        if (!is_null($value) && $value !== '1') {
            $this->setErrorMessage('Invalid value');
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Optional, if set, must be '1'
     * @param string $value Is email sending history enabled?
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_is_history_enabled($value) {
        if (!is_null($value) && $value !== '1') {
            $this->setErrorMessage('Invalid value');
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Optional, if set, must be '1'
     * @param string $value Is SMTP debug enabled?
     * @return boolean TRUE on validation success, FALSE otherwise.
     */
    protected function check_is_debug_enabled($value) {
        if (!is_null($value) && $value !== '1') {
            $this->setErrorMessage('Invalid value');
            return FALSE;
        }
        return TRUE;
    }
}
