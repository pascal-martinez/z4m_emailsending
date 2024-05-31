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
 * ZnetDK 4 Mobile Email Sending module template : email sent when user's
 * password has changed (Spanish version)
 *
 * File version: 1.0
 * Last update: 05/30/2024
 */

// Email subject
$this->templateSubject = '[[**application_name**]]: nueva contraseña \'[[login_name]]\'';

// Email message body
$this->templateBody = <<<'EOT'
<div style="font-family:Arial,Helvetica,sans-serif;font-size:14px;">
<p>Hola [[user_name]],</p>
<p>Aquí esta su nueva contraseña para conectarse a la aplicación <b>[[**application_name**]]</b> desde su navegador web:</p>
<ul>
    <li>Dirección de Internet: <a href="[[**application_uri**]]?login=[[login_name]]">[[**application_uri**]]</a></li>
    <li>Login: <b>[[login_name]]</b></li>
    <li>Contraseña: <b>[[password_in_clear]]</b></li>
</ul>
<p>Por razones de seguridad, la contraseña <i>tendrá que ser renovada</i> después de su conexión a la aplicación.</p>
<p>Saludos,</p>
<p>[[**sender_name**]]</p>
</div>
EOT;
