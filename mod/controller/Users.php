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
 * ZnetDK 4 Mobile Email Sending module controller
 *
 * File version: 1.0
 * Last update: 05/17/2024
 */
namespace z4m_emailsending\mod\controller;

use \z4m_emailsending\mod\EmailToSend;
class Users extends \AppController {
    /**
     * Notifies user about their account creation or modification and gives
     * their new credentials.
     * Supported ZnetDK version: 2.9 or higher.
     * @param boolean $isNewUser TRUE if the user account has been created,
     * otherwise FALSE.
     * @param string $passwordInClear User's password in clear
     * @param array $otherUserData Extra informations about the user
     * @throws Exception Email sending failed
     */
    static public function notify($isNewUser, $passwordInClear, $otherUserData) {
        if ($isNewUser && !MOD_Z4M_EMAILSENDING_NOTIFY_USER_ON_CREATION
                || (!$isNewUser && !MOD_Z4M_EMAILSENDING_NOTIFY_USER_ON_PASSWORD_CHANGE)) {
            return; // Notification disabled
        }
        $emailTemplate = $isNewUser ? 'new-user' : 'password-change';
        $email = new EmailToSend();
        $email->useTemplate($emailTemplate,
            [
                '**application_name**' => NULL
            ],
            [
                '**application_name**' => NULL,
                '**application_uri**' => NULL,
                'login_name' => $otherUserData['login_name'],
                'user_name' => $otherUserData['user_name'],
                'password_in_clear' => $passwordInClear,
                '**sender_name**' => NULL
            ],
            ['password_in_clear']
        );
        $email->addAddress($otherUserData['user_email'], $otherUserData['user_name']);
        $email->businessReference = "user_{$otherUserData['user_id']}";
        $email->send();
    }
}
