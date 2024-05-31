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
 * reset is requested (Spanish version)
 *
 * File version: 1.0
 * Last update: 05/18/2024
 */

// Email subject
$this->templateSubject = '[[**application_name**]]: solicitud de nueva contraseña';

// Email message body
$this->templateBody = <<<'EOT'
<div style="font-family:Arial,Helvetica,sans-serif;font-size:14px;">
<p>Hola [[user_name]],</p>
<p>Ha solicitado una nueva contraseña para iniciar sesión en la aplicación de [[**application_name**]].</p>
<p>Confirme su solicitud haciendo clic en el siguiente enlace o copiándolo en la barra de direcciones de su navegador de Internet :</p>
<p>[[confirmation_link]]</p>
<p>Si usted no es la fuente de este mensaje, ignórelo.</p>
<p>Saludos,</p>
<p>[[**sender_name**]]</p>
</div>
EOT;
