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
 * ZnetDK 4 Mobile Email Sending module SQL script
 *
 * File version: 1.0
 * Last update: 05/15/2024
 */

CREATE TABLE IF NOT EXISTS `zdk_email_sending_server_settings` (
  `id` int(11) NOT NULL COMMENT 'Internal identifier',
  `is_smtp` BOOLEAN NOT NULL COMMENT 'Is SMTP?',
  `is_sending_enabled` BOOLEAN NOT NULL COMMENT 'Is sending enabled?',
  `sender_name` VARCHAR (255) NULL COMMENT 'Sender name',
  `sender_email` VARCHAR (255) NULL COMMENT 'Sender name',
  `host` VARCHAR(100) NULL COMMENT 'SMTP server host',
  `port` MEDIUMINT NULL COMMENT 'TCP/IP port number',
  `auth` BOOLEAN NULL COMMENT 'Is SMTP server authentication required?',
  `username` VARCHAR (255) NULL COMMENT 'User name',
  `password` VARCHAR (255) NULL COMMENT 'Password',
  `security` VARCHAR (255) NULL COMMENT 'ssl or tls',
  `is_history_enabled` BOOLEAN NULL COMMENT 'Is email history enabled?',
  `is_debug_enabled` BOOLEAN NULL COMMENT 'Is debugging enabled?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci 
    COMMENT = 'Email sending settings';

INSERT INTO `zdk_email_sending_server_settings` (`id`, `is_smtp`,
     `is_sending_enabled`) VALUES (1, 0, 1);

CREATE TABLE IF NOT EXISTS `zdk_email_sending_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Internal Identifier',
  `message_id` varchar(200) DEFAULT NULL COMMENT 'Message identifier',
  `reference` varchar(100) DEFAULT NULL COMMENT 'Business reference',
  `sending_date` datetime NOT NULL COMMENT 'Sending date',
  `to_addresses` TEXT COMMENT 'Recipients',
  `cc_addresses` TEXT COMMENT 'Recipients in copy',
  `bcc_addresses` TEXT COMMENT 'Recipients in blind copy',
  `from_address` TEXT NOT NULL COMMENT 'Sender',
  `subject` TEXT NOT NULL COMMENT 'Email subject',
  `body` TEXT NOT NULL COMMENT 'Email body',
  `attachments` TEXT COMMENT 'Attachments',
  `status` tinyint(1) NOT NULL COMMENT 'Status',
  `error_message` TEXT NULL COMMENT 'Error message',
  PRIMARY KEY (`id`),
  KEY `reference` (`reference`),
  KEY `to_addresses` (`to_addresses`(255)),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Sent email history' AUTO_INCREMENT=1 ;