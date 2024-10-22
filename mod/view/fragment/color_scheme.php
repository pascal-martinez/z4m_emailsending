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
 * ZnetDK 4 Mobile Email Sending module view fragment
 *
 * File version: 1.0
 * Last update: 10/22/2024
 */
$color = [
    'content' => 'w3-theme-light',
    'modal_header' => 'w3-theme-dark',
    'modal_content' => 'w3-theme-light',
    'modal_footer' => 'w3-theme-l4',
    'modal_footer_border_top' => 'w3-border-theme',
    'btn_action' => 'w3-theme-action',
    'btn_hover' => 'w3-hover-theme',
    'btn_submit' => 'w3-green',
    'btn_cancel' => 'w3-red',
    'msg_error' => 'w3-red',
    'filter_bar' => 'w3-theme',
    'list_border_bottom' => 'w3-border-theme',
    'icon' => 'w3-text-theme',
    'form_title' => 'w3-text-theme',
    'form_title_border_bottom' => 'w3-border-theme'
];
if (is_array(MOD_Z4M_EMAILSENDING_COLOR_SCHEME)) {
    $color = MOD_Z4M_EMAILSENDING_COLOR_SCHEME;
} elseif (defined('CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME')) {
    $color = CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME;
}