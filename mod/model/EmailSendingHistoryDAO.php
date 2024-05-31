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
 * ZnetDK 4 Mobile Email sent history module DAO
 *
 * File version: 1.0
 * Last update: 05/21/2024 
 */
namespace z4m_emailsending\mod\model;

class EmailSendingHistoryDAO extends \DAO {

    protected function initDaoProperties() {
        $this->table = "zdk_email_sending_history";
        $this->dateColumns = array('sending_date');
    }
    
    public function applySearchCriteria($criteria) {
        if (key_exists('status', $criteria)) {
            $this->setStatusAsFilter($criteria['status']);
        }
        if (key_exists('start', $criteria)) {
            $this->setStartAsFilter($criteria['start']);
        }
        if (key_exists('end', $criteria)) {
            $this->setEndAsFilter($criteria['end']);
        }
    }
    
    protected function setStatusAsFilter($status) {
        if ($this->filterClause === FALSE) {
            $this->filterClause = 'WHERE ';
        } else {
            $this->filterClause .= ' AND ';
        }
        $this->filterClause .= 'status = ?';
        $this->filterValues []= $status;
    }
    
    protected function setStartAsFilter($startDate) {
        if ($this->filterClause === FALSE) {
            $this->filterClause = 'WHERE ';
        } else {
            $this->filterClause .= ' AND ';
        }
        $this->filterClause .= 'sending_date >= ?';
        $this->filterValues []= "{$startDate}T00:00:00Z";
    }
    
    protected function setEndAsFilter($endDate) {
        if ($this->filterClause === FALSE) {
            $this->filterClause = 'WHERE ';
        } else {
            $this->filterClause .= ' AND ';
        }
        $this->filterClause .= 'sending_date <= ?';
        $this->filterValues []= "{$endDate}T23:59:59Z";
    }
    
}
