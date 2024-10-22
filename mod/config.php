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
 * Parameters of the ZnetDK 4 Mobile Email Sending module
 *
 * File version: 1.4
 * Last update: 10/22/2024
 */

/**
 * Forgotten password link is visible
 */
define('CFG_FORGOT_PASSWORD_ENABLED', TRUE);

/**
 * Path of the SQL script to update the database schema
 * @var string Path of the SQL script
 */
define('MOD_Z4M_EMAILSENDING_SQL_SCRIPT_PATH', ZNETDK_MOD_ROOT
        . DIRECTORY_SEPARATOR . 'z4m_emailsending' . DIRECTORY_SEPARATOR
        . 'mod' . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR
        . 'z4m_emailsending.sql');

/**
 * Encryption key to secure SMTP user account stored in database.
 * @var string The encryption key is to set within the 'config.php' of the
 * application to strengh security level.
 * For example: 'My secret text key' 
 */
define('MOD_Z4M_EMAILSENDING_ENCRYPTION_KEY', NULL);

/**
 * Notification by email when a user is created 
 * @var boolean If TRUE, an email is sent to user, otherwise, no email is sent.
 */
define('MOD_Z4M_EMAILSENDING_NOTIFY_USER_ON_CREATION', TRUE);

/**
 * Notification by email when a user's password is changed from the user 
 * management view.
 * @var boolean If TRUE, an email is sent to user, otherwise, no email is sent.
 */
define('MOD_Z4M_EMAILSENDING_NOTIFY_USER_ON_PASSWORD_CHANGE', TRUE);

/**
 * Sets the PHPMailer SMTP Debug level.
 * @var int SMTP Debug level: 1 (CLIENT), 2(SERVER), 3(CONNECTION)
 * or 4 (LOWLEVEL).
 */
define('MOD_Z4M_EMAILSENDING_SMTP_DEBUG_LEVEL', 4);

/**
 * Color scheme of the Email sending UI.
 * @var array|NULL Colors used to display the home menu. The expected array keys
 * are 'content', 'modal_header', 'modal_content' ,'modal_footer',
 * 'modal_footer_border_top', 'btn_action', 'btn_hover', 'btn_submit', 
 * 'btn_cancel', 'msg_error', 'filter_bar', 'list_border_bottom', 'icon',
 * 'form_title' and 'form_title_border_bottom';
 * If NULL, default color CSS classes are applied.
 */
define('MOD_Z4M_EMAILSENDING_COLOR_SCHEME', NULL);

/**
 * Module version number
 * @var string Version
 */
define('MOD_Z4M_EMAILSENDING_VERSION_NUMBER','1.4');
/**
 * Module version date
 * @var string Date in W3C format
 */
define('MOD_Z4M_EMAILSENDING_VERSION_DATE','2024-10-22');