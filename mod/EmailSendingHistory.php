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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK 4 Mobile Email Sending module History class
 * 
 * File version: 1.1
 * Last update: 09/08/2024
 */
namespace z4m_emailsending\mod;

/**
 * Storage of the email sent in history SQL table.
 * Supported ZnetDK version: 2.9 or higher.
 */
class EmailSendingHistory {    
    
    /**
     * Returns email sending history rows
     * @param int $first The first row number to return
     * @param int $count The number of rows to return
     * @param array $searchCriteria Filter criteria. Expected keys are 'status',
     * 'start_date' and 'end_date'.
     * @param string $sortCriteria Sort criteria
     * @param array $rowsFound
     * @return int Total number of history rows in database
     * @throws \Exception When query failed
     */
    static public function getAll($first, $count, $searchCriteria, $sortCriteria, &$rowsFound, $excludeBody = TRUE) {
        $dao = new model\EmailSendingHistoryDAO();
        EmailServerSettings::createModuleSqlTable($dao);
        $dao->setSortCriteria($sortCriteria);
        if (is_array($searchCriteria)) {
            $dao->applySearchCriteria($searchCriteria);
        }
        $total = $dao->getCount();
        if (!is_null($first) && !is_null($count)) {
            $dao->setLimit($first, $count);
        }
        while($row = $dao->getResult()) {
            if ($excludeBody) {
                unset($row['body']);
            }
            $row['to_addresses'] = self::getDisplayAddress($row['to_addresses']);
            $row['cc_addresses'] = self::getDisplayAddress($row['cc_addresses']);
            $row['bcc_addresses'] = self::getDisplayAddress($row['bcc_addresses']);
            $row['from_address'] = self::getDisplayAddress($row['from_address']);
            $rowsFound[] = $row;
        }
        return $total;
    }
    
    /**
     * Returns history row for the specified identifier
     * @param int $id row ID
     * @return array Row data
     */
    static public function getById($id) {
        $dao = new model\EmailSendingHistoryDAO();
        return $dao->getById($id);
    }
    
    /**
     * Adds a new history row
     * @param EmailToSend $email Email data
     * @param boolean $status Sending status, TRUE if success, FALSE otherwise.
     * @param string $errorMessage Error message if status is FALSE.
     */
    static public function add($email, $status, $errorMessage) {
        $newRow = [
            'message_id' => $email->getLastMessageID(),
            'reference' => $email->businessReference,
            'sending_date' => \General::getCurrentW3CDate(TRUE),
            'to_addresses' => self::getAddressesAsString($email->getToAddresses()),
            'cc_addresses' => self::getAddressesAsString($email->getCcAddresses()),
            'bcc_addresses' => self::getAddressesAsString($email->getBccAddresses()),
            'from_address' => self::getRfc822Address($email->From, $email->FromName),
            'subject' => $email->Subject,
            'body' => EmailTemplate::replaceSensitiveValues($email->Body),
            'attachments' => self::getAttachmentsAsString($email->getAttachments()),
            'status' => $status,
            'error_message' => $errorMessage
        ];
        $dao = new model\EmailSendingHistoryDAO();
        $autocommit = !\Database::inTransaction();
        $dao->store($newRow, $autocommit);
    }
    
    /**
     * Purge history rows. If search criteria are set, only the matching rows
     * are removed
     * @param array $searchCriteria Filter criteria. Expected keys are 'status',
     * 'start_date' and 'end_date'.
     * @return int The number of rows removed
     */
    static public function purge($searchCriteria) {
        $dao = new model\EmailSendingHistoryDAO();
        if (is_array($searchCriteria)) {
            $dao->applySearchCriteria($searchCriteria);
        } else {
            $dao->applySearchCriteria(['start' => '2020-01-01']);
        }
        return $dao->remove(NULL);
    }
    
    static protected function getBodyWithoutSensitiveValues($body) {
        $startTag = '<span class="sensitive">';
        $endTag = '</span>';
        return preg_replace('#(' . $startTag . ').*?(' . $endTag .')#', '$1$2', $body);
    }
    
    static protected function getAttachmentsAsString($attachments) {
        if (count($attachments) > 0) {
            return implode(',', array_column($attachments, 1));
        } 
        return NULL;
    }
    
    static protected function getAddressesAsString($addresses) {
        $newAddresses = [];
        foreach ($addresses as $address) {
            $newAddresses []= self::getRfc822Address($address[0], $address[1]); 
        }
        if (count($newAddresses) > 0) {
            return implode(',', $newAddresses);
        } 
        return NULL;
    }
    
    static protected function getRfc822Address($emailAddress, $name) {
        if (is_string($name) && strlen($name) > 0) {
            return '"' . $name . '" <' . $emailAddress . '>';
        }
        return $emailAddress;
    }
    
    static protected function getDisplayAddress($rfc822Address) {
        $sender = explode('<', $rfc822Address);
        if (count($sender) !== 2) {
            return $rfc822Address;
        }
        return trim(str_replace('"', '', $sender[0]));
    }
}
