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
 * ZnetDK 4 Mobile Email Sending module history view
 *
 * File version: 1.0
 * Last update: 05/22/2024
 */
$email = $this->viewCaller;
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo MOD_Z4M_EMAILSENDING_HISTORY_SEE_EMAIL_LABEL. ' | ' . LC_PAGE_TITLE; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            body {
                font-family: Arial;
                font-size: 14px;
            }
            div.message-id {
                font-size: 10px;
            }
            span.label {
                display: inline-block;
                width: 110px;
                color: #666;
            }
            span.subject {
                font-weight: bold;
            }
            span.attachments {
                font-style: italic;
            }
            div.message-header,
            div.message-attachments,
            div.message-body {
                margin-top: 10px;
                padding-top: 10px;
                border-top: 1pt solid #ccc;
            }
            div.message-attachments.is-hidden {
                display: none;
            }
        </style>
    </head>
    <body>
        <div class="message-id">
            <div><label>Message ID: </label><span><?php echo htmlentities($email['message_id']); ?></span></div>
        </div>
        <div class="message-header">
            <div>
                <span class="label"><?php echo MOD_Z4M_EMAILSENDING_HISTORY_SUBJECT_LABEL; ?></span>
                <span class="subject"><?php echo $email['subject']; ?></span></div>
            <div>
                <span class="label"><?php echo MOD_Z4M_EMAILSENDING_HISTORY_SENDER_FROM_LABEL; ?></span>
                <span><?php echo htmlentities($email['from_address']); ?></span>
            </div>
            <div>
                <span class="label"><?php echo MOD_Z4M_EMAILSENDING_HISTORY_RECIPIENTS_TO_LABEL; ?></span>
                <span><?php echo htmlentities($email['to_addresses']); ?></span>
            </div>
<?php if ($email['cc_addresses'] !== '') : ?>
            <div>
                <span class="label"><?php echo MOD_Z4M_EMAILSENDING_HISTORY_RECIPIENTS_CC_LABEL; ?></span>
                <span><?php echo htmlentities($email['cc_addresses']); ?></span>
            </div>
<?php endif; ?>
<?php if ($email['bcc_addresses'] !== '') : ?>
            <div>
                <span class="label"><?php echo MOD_Z4M_EMAILSENDING_HISTORY_RECIPIENTS_BCC_LABEL; ?></span>
                <span><?php echo htmlentities($email['bcc_addresses']); ?></span>
            </div>
<?php endif; ?>
            <div>
                <span class="label"><?php echo MOD_Z4M_EMAILSENDING_HISTORY_DATETIME_SHORT_LABEL; ?></span>
                <span><?php echo $email['sending_date_locale']; ?></span>
            </div>
        </div>
        <div class="message-attachments<?php echo $email['attachments'] === '' ? ' is-hidden' : ''; ?>">
            <div>
                <span class="label"><?php echo MOD_Z4M_EMAILSENDING_HISTORY_ATTACHMENTS_LABEL; ?></span>
                <span class="attachments"><?php echo $email['attachments']; ?></span>
            </div>
        </div>
        <div class="message-body"><?php echo $email['body']; ?></div>
    </body>
</html>
