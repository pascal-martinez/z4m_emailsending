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
 * Last update: 05/21/2024
 */

namespace z4m_emailsending\mod\controller;

use \z4m_emailsending\mod\EmailSendingHistory;
use \z4m_emailsending\mod\EmailServerSettings;

/**
 * App controller dedicated to HTTP requests sent by the Email sending settings
 * view (see 'z4m_email_settings.php') and by the Email sending history view
 * (see 'z4m_email_history.php').
 * Supported ZnetDK version: 2.9 or higher.
 */
class Z4MEmailSendingCtrl extends \AppController {

    /**
     * Evaluates whether action is allowed or not.
     * When authentication is required, action is allowed if connected user has
     * full menu access or if has a profile allowing access to the following 
     * views: 'z4m_email_sending_history' or 'z4m_email_sending_settings'.
     * If no authentication is required, action is allowed if the expected view
     * menu item is declared in the 'menu.php' script of the application.
     * @param string $action Action name
     * @return Boolean TRUE if action is allowed, FALSE otherwise
     */
    static public function isActionAllowed($action) {
        $status = parent::isActionAllowed($action);
        if ($status === FALSE) {
            return FALSE;
        }
        $actionView = [
            'history' => 'z4m_email_sending_history',
            'download' => 'z4m_email_sending_history',
            'purge' => 'z4m_email_sending_history',
            'settings' => 'z4m_email_sending_settings',
            'storeSettings' => 'z4m_email_sending_settings',
            'sendTestEmail' => 'z4m_email_sending_settings',
            'testSMTPConnection' => 'z4m_email_sending_settings'
        ];
        $menuItem = key_exists($action, $actionView) ? $actionView[$action] : NULL;
        return CFG_AUTHENT_REQUIRED === TRUE
            ? \controller\Users::hasMenuItem($menuItem) // User has right on menu item
            : \MenuManager::getMenuItem($menuItem) !== NULL; // Menu item declared in 'menu.php'
    }
    
    // Controller's actions
    
    /**
     * Returns Email sending history
     * @return \Response Email sending history in JSON
     */
    static protected function action_history() {
        $request = new \Request();
        $first = $request->first; $count = $request->count;
        $searchCriteria = is_string($request->search_criteria) ? json_decode($request->search_criteria, TRUE) : NULL;
        $response = new \Response();
        $rowsFound = array();
        try {
            $response->total = EmailSendingHistory::getAll($first, $count, $searchCriteria, 'id DESC', $rowsFound);
            $response->rows = $rowsFound;
            $response->success = TRUE;
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            $response->setFailedMessage(LC_MSG_CRI_ERR_SUMMARY, LC_MSG_CRI_ERR_GENERIC);
        }
        return $response;
    }
    
    static protected function action_download() {
        $request = new \Request();
        $response = new \Response();
        $row = EmailSendingHistory::getById($request->id);
        $response->setView('z4m_email_sending_history_see_email', 'view', $row);
        return $response;
    }
    
    static protected function action_purge() {
        $request = new \Request();
        $searchCriteria = is_string($request->search_criteria) ? json_decode($request->search_criteria, TRUE) : NULL;
        $response = new \Response();
        try {
            EmailSendingHistory::purge($searchCriteria);
            $response->setSuccessMessage(NULL, MOD_Z4M_EMAILSENDING_HISTORY_PURGE_SUCCESS);
        } catch (Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            $response->setFailedMessage(LC_MSG_CRI_ERR_SUMMARY, LC_MSG_CRI_ERR_GENERIC);
        }
        return $response;
    }
    
    /**
     * Returns Email sending settings
     * @return \Response Settings in JSON format
     */
    static protected function action_settings() {
        $response = new \Response();
        try {
            $settings = new EmailServerSettings();
            $response->setResponse($settings->getRow());
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            $response->setCriticalMessage(LC_MSG_CRI_ERR_GENERIC, $ex);
        }
        return $response;
    }

    /**
     * Stores settings
     * @return \Response Success message or error message in JSON
     */
    static protected function action_storeSettings() {
        $response = new \Response();
        try {
            $settings = new EmailServerSettings(TRUE);
            $validation = $settings->validate();
            if (is_array($validation)) {
                $response->setFailedMessage(NULL, $validation['message'],
                        $validation['property']);
            } else {
                $settings->store();
                $response->setSuccessMessage(NULL, MOD_Z4M_EMAILSENDING_SETTINGS_STORAGE_SUCCESS);
            }
        } catch (\ZDKException $ex) {
            $response->setFailedMessage(NULL, MOD_Z4M_EMAILSENDING_SETTINGS_STORAGE_FAILED
                    . $ex->getMessageWithoutCode());
        }
        catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            $response->setCriticalMessage(LC_MSG_CRI_ERR_GENERIC, $ex);
        }
        return $response;
    }

    /**
     * Sends a test email from the 'test-email' email template.
     * @return \Response Success message or failed message in JSON.
     */
    static protected function action_sendTestEmail() {
        $request = new \Request();
        $response = new \Response();
        try {
            EmailServerSettings::sendTestEmail($request->recipient_email);
            $response->setSuccessMessage(NULL, MOD_Z4M_EMAILSENDING_SETTINGS_SEND_TEST_EMAIL_SUCCESS);
        } catch (\Exception $ex) {
            $response->setFailedMessage(NULL, MOD_Z4M_EMAILSENDING_SETTINGS_SEND_TEST_EMAIL_FAILED
                    . '(' . $ex->getMessage() . ')');
        }
        return $response;
    }

    /**
     * Tests connection to the SMTP server.
     * @return \Response Success message or failed message in JSON.
     */
    static protected function action_testSMTPConnection() {
        $response = new \Response();
        $title = MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_SMTP_TEST_BUTTON_LABEL;
        try {
            $settings = new EmailServerSettings();
            $settings->checkSMTPConnection();
            $response->setSuccessMessage($title,
                    MOD_Z4M_EMAILSENDING_SETTINGS_SMTP_CONNECTION_TEST_SUCCESS);
        } catch (\Exception $ex) {
            $response->setFailedMessage($title,
                    MOD_Z4M_EMAILSENDING_SETTINGS_SMTP_CONNECTION_TEST_FAILED
                    . ' (' . $ex->getMessage() . ')');
        }
        return $response;
    }

}
