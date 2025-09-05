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
 * File version: 1.4
 * Last update: 09/04/2025
 */

// Setting the $color $variable
require 'fragment/color_scheme.php';
?>
<style>
    #z4m-email-sending-history-list-filter .no-wrap {
        white-space: nowrap;
    }
    #z4m-email-sending-history-list-header {
        position: sticky;
    }
    #z4m-email-sending-history-list .status-col {
        width: 36px;
        font-family: monospace;
        font-weight: 600;
    }
    #z4m-email-sending-history-list li .see {
        margin: 6px 0 0 0;
    }
    #z4m-email-sending-history-see-email iframe {
        border: 0;
        height: 65vh;
    }
</style>
<!-- Filter by dates and status -->
<form id="z4m-email-sending-history-list-filter" class="w3-padding w3-panel <?php echo $color['filter_bar']; ?>">
    <div class="w3-cell w3-mobile w3-margin-bottom">
        <div class="w3-cell no-wrap"><i class="fa fa-calendar"></i>&nbsp;<b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_FILTER_PERIOD; ?></b>&nbsp;</div>
        <div class="w3-cell w3-mobile">
            <input class="w3-padding" type="date" name="start_filter">
            <input class="w3-padding w3-margin-right" type="date" name="end_filter">
        </div>
    </div>
    <div class="w3-cell w3-mobile w3-margin-bottom">
        <div class="w3-cell no-wrap"><i class="fa fa-list"></i>&nbsp;<b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_STATUS_LABEL; ?></b>&nbsp;</div>
        <div class="w3-cell no-wrap">
            <input id="z4m-email-sending-history-list-filter-status-all" class="w3-radio" type="radio" value="" name="status_filter" checked>
            <label for="z4m-email-sending-history-list-filter-status-all"><?php echo MOD_Z4M_EMAILSENDING_HISTORY_FILTER_STATUS_ALL; ?></label>&nbsp;&nbsp;
            <input id="z4m-email-sending-history-list-filter-status-ok" class="w3-radio" type="radio" value="1" name="status_filter">
            <label for="z4m-email-sending-history-list-filter-status-ok">OK</label>&nbsp;&nbsp;
            <input id="z4m-email-sending-history-list-filter-status-ko" class="w3-radio" type="radio" value="0" name="status_filter">
            <label for="z4m-email-sending-history-list-filter-status-ko" class="w3-margin-right">KO</label>
        </div>
    </div>
    <div class="w3-cell">
        <button class="purge w3-button <?php echo $color['btn_action']; ?>" type="button" data-confirmation="<?php echo MOD_Z4M_EMAILSENDING_HISTORY_PURGE_CONFIRMATION_TEXT; ?>">
            <i class="fa fa-trash fa-lg"></i> <?php echo MOD_Z4M_EMAILSENDING_HISTORY_PURGE_BUTTON_LABEL; ?>
        </button>
    </div>
</form>
<!-- Header -->
<div id="z4m-email-sending-history-list-header" class="w3-row <?php echo $color['content']; ?> w3-hide-small w3-border-bottom <?php echo $color['list_border_bottom']; ?>">
    <div class="w3-col m3 l2 w3-padding-small"><b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_DATETIME_LABEL; ?></b></div>
    <div class="w3-col m2 l2 w3-padding-small"><b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_SENDER_LABEL; ?></b></div>
    <div class="w3-col m2 l2 w3-padding-small"><b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_RECIPIENTS_LABEL; ?></b></div>
    <div class="w3-col m2 l3 w3-padding-small"><b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_MESSAGE_LABEL; ?></b></div>
    <div class="w3-col m3 l3 w3-padding-small"><b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_STATUS_LABEL; ?></b></div>
</div>
<!-- List of sent items -->
<ul id="z4m-email-sending-history-list" class="w3-ul w3-hide"
    data-zdk-load="Z4MEmailSendingCtrl:history"
    data-url="<?php echo General::getURIforDownload('Z4MEmailSendingCtrl'); ?>">
    <li class="<?php echo $color['list_border_bottom']; ?>">
        <div class="w3-row w3-stretch">
            <div class="w3-col s12 m3 l2 w3-padding-small">
                <i class="fa fa-calendar w3-hide-large w3-hide-medium"></i>
                <b>{{sending_date_locale}}</b>
            </div>
            <div class="w3-col s12 m2 l2 w3-padding-small"><b class="w3-hide-medium w3-hide-large"><?php echo MOD_Z4M_EMAILSENDING_HISTORY_SENDER_FROM_LABEL; ?> </b>{{from_address}}</div>
            <div class="w3-col s12 m2 l2 w3-padding-small">
                <div class="to w3-hide"><b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_RECIPIENTS_TO_LABEL; ?></b> <span class="value">{{to_addresses}}</span></div>
                <div class="cc w3-hide"><b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_RECIPIENTS_CC_LABEL; ?></b> <span class="value">{{cc_addresses}}</span></div>
                <div class="bcc w3-hide"><b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_RECIPIENTS_BCC_LABEL; ?></b> <span class="value">{{bcc_addresses}}</span></div>
            </div>
            <div class="w3-col s12 m2 l3 w3-padding-small">
                <div><b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_SUBJECT_LABEL; ?></b> <i>{{subject}}</i></div>
                <div class="attachments w3-hide"><b><?php echo MOD_Z4M_EMAILSENDING_HISTORY_ATTACHMENTS_LABEL; ?></b> <span class="value">{{attachments}}</span></div>
                <div class="see">
                    <i class="fa fa-eye fa-lg <?php echo $color['icon']; ?>"></i>
                    <a href="{{id}}"><?php echo MOD_Z4M_EMAILSENDING_HISTORY_SEE_EMAIL_LABEL; ?> ID={{id}}</a>
                </div>
            </div>
            <div class="w3-col s12 m3 l3 w3-padding-small">
                <div class="w3-row">
                    <div class="w3-col status-col" style="">
                        <span class="w3-tag {{status_class}}">{{status_label}}</span>
                    </div>
                    <div class="w3-rest">{{error_message}}</div>
                </div>
            </div>
        </div>
    </li>
    <li><h3 class="<?php echo $color['msg_error']; ?> w3-center w3-stretch"><i class="fa fa-frown-o"></i>&nbsp;<?php echo LC_MSG_INF_NO_RESULT_FOUND; ?></h3></li>
</ul>
<div id="z4m-email-sending-history-see-email" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container <?php echo $color['modal_header']; ?>">
            <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
            <h4>
                <i class="fa fa-paper-plane-o fa-lg"></i>
                <?php echo MOD_Z4M_EMAILSENDING_HISTORY_SEE_EMAIL_LABEL; ?> ID=<span class="title"></span>
            </h4>
        </header>
        <div class="w3-row">
            <iframe class="w3-col <?php echo $color['modal_content']; ?>" data-error="<?php echo LC_MSG_CRI_ERR_GENERIC; ?>"></iframe>
        </div>
        <footer class="w3-container w3-padding-16 w3-border-top <?php echo $color['modal_footer_border_top']; ?> <?php echo $color['modal_footer']; ?>">
            <button type="button" class="cancel w3-button <?php echo $color['btn_cancel']; ?>">
                <i class="fa fa-close fa-lg"></i>&nbsp;
                <?php echo LC_BTN_CLOSE; ?>
            </button>
        </footer>
    </div>
</div>
<script>
    <?php if (CFG_DEV_JS_ENABLED) : ?>
    console.log("'z4m_email_sending_history' ** For debug purpose **");
    <?php endif; ?>
    $(function(){
        // History list is instantiated
        const historyList = znetdkMobile.list.make('#z4m-email-sending-history-list', true, false);
        // Filters applied before list loading
        historyList.beforeSearchRequestCallback = function(requestData) {
            const JSONFilters = getFilterCriteria();
            if (JSONFilters !== null) {
                requestData.search_criteria = JSONFilters;
            }
        };
        historyList.loadedCallback = function(rowCount, pageNumber) {
            const purgeBtn = $('#z4m-email-sending-history-list-filter button.purge');
            purgeBtn.prop('disabled', rowCount === 0 && pageNumber === 1);
        };
        function getFilterCriteria() {
            const filterForm = z4m.form.make('#z4m-email-sending-history-list-filter'),
                status = filterForm.getInputValue('status_filter'),
                startDate = filterForm.getInputValue('start_filter'),
                endDate = filterForm.getInputValue('end_filter'),
                filters = {};
            if (status !== '') {
                filters.status = status;
            }
            if (startDate !== '') {
                filters.start = startDate;
            }
            if (endDate !== '') {
                filters.end = endDate;
            }
            if (Object.keys(filters).length > 0) {
                return JSON.stringify(filters);
            }
            return null;
        }
        // Customization of the list display
        historyList.beforeInsertRowCallback = function(rowData) {
            rowData.status_class = rowData.status === '1' ? 'w3-green' : 'w3-red';
            rowData.status_label = rowData.status === '1' ? 'OK' : 'KO';
            if (rowData.error_message.length > 0) {
                const shortMsg = rowData.error_message.length < 106
                    ? rowData.error_message : rowData.error_message.substring(0, 106) + '...';
                rowData.error_message = '<span class="w3-text-red" title="'
                        + rowData.error_message + '"><i class="fa fa-warning"></i> <b>'
                        + shortMsg + '</b></span>';
            }
        };
        // Filled cells are displayed
        historyList.afterInsertRowCallback = function(newRowEl) {
            const classes = ['.to', '.cc', '.bcc', '.attachments'];
            classes.forEach(function(curClass){
                if (newRowEl.find(curClass + ' .value').text() !== '') {
                    newRowEl.find(curClass).removeClass('w3-hide');
                }
            });
        };
        // Filter change events
        $('#z4m-email-sending-history-list-filter input').on('change.z4m_email_sending_history', function(){
            if ($(this).attr('name') === 'start_filter') {
                const startDate = new Date($(this).val()),
                    endDateEl = $('#z4m-email-sending-history-list-filter input[name=end_filter]'),
                    endDate = new Date(endDateEl.val());
                if (startDate > endDate) {
                    endDateEl.val($(this).val());
                }
            } else if ($(this).attr('name') === 'end_filter') {
                const endDate = new Date($(this).val()),
                    startDateEl = $('#z4m-email-sending-history-list-filter input[name=start_filter]'),
                    startDate = new Date(startDateEl.val());
                if (startDate > endDate) {
                    startDateEl.val($(this).val());
                }
            }
            historyList.refresh();
        });
        // Purge button click events
        $('#z4m-email-sending-history-list-filter button.purge').on('click.z4m_email_sending_history', function(){
            z4m.messages.ask($(this).text(), $(this).data('confirmation'), null, function(isOK){
                if(!isOK) {
                    return;
                }
                const requestObj = {
                    controller: 'Z4MEmailSendingCtrl',
                    action: 'purge',
                    callback(response) {
                        if (response.success) {
                            historyList.refresh();
                            z4m.messages.showSnackbar(response.msg);
                        }
                    }
                };
                const JSONFilters = getFilterCriteria();
                if (JSONFilters !== null) {
                    requestObj.data = {search_criteria: JSONFilters};
                }
                z4m.ajax.request(requestObj);
            });
        });
        // See email
        $('#z4m-email-sending-history-list').on('click.z4m_email_sending_history', 'li .see a', function(e){
            e.preventDefault();
            const $this = this, emailId = $(this).attr('href'),
                downloadUrl = $('#z4m-email-sending-history-list').data('url'),
                emailModalObj = z4m.modal.make('#z4m-email-sending-history-see-email'),
                iframeEl = emailModalObj.element.find('iframe');
            emailModalObj.setTitle(emailId);
            iframeEl[0].onload = function() {
                emailModalObj.open(null, function(){ // On close, focus restored to the clicked link
                    $this.focus();
                });
                z4m.ajax.toggleLoader?.(false);
                emailModalObj.element.find('button.cancel')[0].focus();
            };
            iframeEl[0].onerror = function() {
                const filterForm = z4m.form.make('#z4m-email-sending-history-list-filter');
                filterForm.showError(iframeEl[0].dataset.error);
                z4m.ajax.toggleLoader?.(false);
            };
            z4m.ajax.toggleLoader?.(true);
            iframeEl.attr('src', downloadUrl + '&id=' + emailId);
        });
        // List header sticky position taking in account ZnetDK autoHideOnScrollEnabled property
        onTopSpaceChange();
        $('body').on('topspacechange.z4m_email_sending_history', onTopSpaceChange);
        function onTopSpaceChange() {
            $('#z4m-email-sending-history-list-header').css('top', znetdkMobile.header.autoHideOnScrollEnabled
                ? 0 : znetdkMobile.header.getHeight()-1);
        }
    });
</script>