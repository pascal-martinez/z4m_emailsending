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
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK 4 Mobile Email Sending module App controller
 *
 * File version: 1.0
 * Last update: 05/17/2024
 */
namespace z4m_emailsending\mod\controller;

use \z4m_emailsending\mod\EmailToSend;
class ForgotPassword extends \AppController {

    /**
     * Sends an email to user who requested a new password ('forgot password?' link)
     * in order to get their confirmation before resetting their password.
     * This method is called by controller\Forgotten::action_requestpassword().
     * Supported ZnetDK version: 2.9 or higher.
     * @param string $emailAddress User's email address
     * @param string $confirmationUrl URL of the application to confirm password reset
     * @return boolean TRUE if processed
     */
    static public function sendConfirmation($emailAddress, $confirmationUrl) {
        self::checkIsForgotPasswordAllowed();
        $userInfos = self::checkIsAllowedEmail($emailAddress);
        $email = new EmailToSend();
        $email->useTemplate('password-request',
            [
                '**application_name**' => NULL
            ],
            [
                '**application_name**' => NULL,
                'user_name' => $userInfos['user_name'],
                'confirmation_link' => self::getHtmlAnchor($confirmationUrl),
                '**sender_name**' => NULL
            ]
        );
        $email->addAddress($emailAddress, $userInfos['user_name']);
        $email->businessReference = "user_{$userInfos['user_id']}";
        $email->send();
        return TRUE;
    }

    /**
     * Sends an email to user after they have confirmed their password reset request
     * This method is called by controller\Forgotten::action_resetpassword().
     * @param string $emailAddress User's email address
     * @param string $tempPassword Temporary password
     * @return boolean TRUE if processed
     */
    static public function sendNewEmail($emailAddress, $tempPassword) {
        self::checkIsForgotPasswordAllowed();
        $userInfos = self::checkIsAllowedEmail($emailAddress);
        $email = new EmailToSend();
        $email->useTemplate('new-password',
            [
                '**application_name**' => NULL
            ],
            [
                '**application_name**' => NULL,
                'user_name' => $userInfos['user_name'],
                'password_in_clear' => $tempPassword,
                '**sender_name**' => NULL
            ],
            ['password_in_clear']
        );
        $email->addAddress($emailAddress, $userInfos['user_name']);
        $email->businessReference = "user_{$userInfos['user_id']}";
        $email->send();
        return TRUE;
    }

    static protected function getHtmlAnchor($url) {
        return '<a href="' . $url . '">' . $url . '</a>';
    }

    static protected function checkIsForgotPasswordAllowed() {
        if (CFG_FORGOT_PASSWORD_ENABLED !== TRUE) {
            throw new \Exception("Action not allowed!", 4);
        }
    }

    static protected function checkIsAllowedEmail($email) {
        $userInfos = \UserManager::getUserInfosByEmail($email);
        if ($userInfos === FALSE) {
            throw new \Exception("Email address is invalid!", 5);
        }
        return $userInfos;
    }

}
