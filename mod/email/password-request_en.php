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
 * ZnetDK 4 Mobile Email Sending module template : email sent when password
 * reset is requested (English version)
 *
 * File version: 1.0
 * Last update: 05/18/2024
 */

// Email subject
$this->templateSubject = '[[**application_name**]]: request for new password';

// Email message body
$this->templateBody = <<<'EOT'
<div style="font-family:Arial,Helvetica,sans-serif;font-size:14px;">
<p>Hello [[user_name]],</p>
<p>You have requested a new password to login to the [[**application_name**]] application.</p>
<p>Please confirm your request by clicking on the link below or by copying it into the address bar of your browser:</p>
<p>[[confirmation_link]]</p>
<p>If you are not the initiator of this request, then please ignore this message.</p>
<p>Regards,</p>
<p>[[**sender_name**]]</p>
</div>
EOT;
