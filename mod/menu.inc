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
 * Menu definition of the ZnetDK 4 Mobile Email Sending module
 *
 * File version: 1.0
 * Last update: 05/24/2024
 */
\MenuManager::addMenuItem(NULL, '_emails', MOD_Z4M_EMAILSENDING_PARENT_MENU_LABEL, 'fa-envelope');
\MenuManager::addMenuItem('_emails', 'z4m_email_sending_history', MOD_Z4M_EMAILSENDING_HISTORY_MENU_LABEL, 'fa-paper-plane');
\MenuManager::addMenuItem('_emails', 'z4m_email_sending_settings', MOD_Z4M_EMAILSENDING_SETTINGS_MENU_LABEL, 'fa-cogs');

