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
 * ZnetDK 4 Mobile Email Sending module settings view
 *
 * File version: 1.1
 * Last update: 10/08/2024
 */
?>
<style>
    #z4m-email-sending-settings-container {
        max-width: 640px;
    }
    #z4m-email-sending-settings-form h3 {
        text-transform: uppercase;
    }
</style>
<div id="z4m-email-sending-settings-container" class="w3-auto w3-section w3-card">
    <header class="w3-theme-dark w3-container">
        <h2 class="w3-large"><i class="fa fa-cogs"></i> <?php echo MOD_Z4M_EMAILSENDING_SETTINGS_TITLE; ?></h2>
    </header>
    <form id="z4m-email-sending-settings-form" class="w3-theme-light" data-zdk-load="Z4MEmailSendingCtrl:settings" 
            data-zdk-submit="Z4MEmailSendingCtrl:storeSettings"
            data-notsaved="<?php echo MOD_Z4M_EMAILSENDING_SETTINGS_FORM_NOT_SAVED_MESSAGE; ?>">
        <section class="w3-container">
            <h3 class="w3-text-theme w3-border-bottom w3-border-theme"><i class="fa fa-envelope-o fa-fw"></i> <?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_TITLE; ?></h3>
            <label><b><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_NAME_LABEL; ?></b>
                <input class="w3-input w3-border w3-margin-bottom" type="text" name="sender_name" placeholder="<?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_NAME_PLACEHOLDER; ?>" maxlength="120">
            </label>
            <label><b><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_EMAIL_LABEL; ?></b>
                <input class="w3-input w3-border w3-margin-bottom" type="email" name="sender_email" placeholder="<?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_EMAIL_PLACEHOLDER; ?>" maxlength="135">
            </label>
            <div class="w3-padding"></div>
            <h3 class="w3-text-theme w3-border-bottom w3-border-theme"><i class="fa fa-server fa-fw"></i> <?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_TITLE; ?></h3>
            <div class="w3-margin-bottom">
                <label class="w3-margin-right">
                    <input class="w3-radio" type="radio" name="is_smtp" value="0">
                    <span><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_LOCAL_LABEL; ?></span>
                </label>
                <label>
                    <input class="w3-radio" type="radio" name="is_smtp" value="1">
                    <span><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_SMTP_LABEL; ?></span>
                </label>
            </div>
            <section class="smtp w3-hide">
                <label><b><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_HOST_LABEL; ?> <span class="w3-text-red">*</span></b>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="host" placeholder="<?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_HOST_PLACEHOLDER; ?>" maxlength="100">
                </label>
                <label><b><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_PORT_LABEL; ?> <span class="w3-text-red">*</span></b>
                    <input class="w3-input w3-border w3-margin-bottom" name="port" type="number" min="0" placeholder="<?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_PORT_PLACEHOLDER; ?>" max="999999">
                </label>
                <label><b><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_SECURITY_LABEL; ?></b>
                    <select class="w3-select w3-border w3-margin-bottom" name="security">
                        <option value=""></option>
                        <option value="ssl"><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_SECURITY_SSL_LABEL; ?></option>
                        <option value="tls"><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_SECURITY_TLS_LABEL; ?></option>
                    </select>
                </label>
                <label class="w3-show-block w3-margin-bottom">
                    <input class="w3-check" type="checkbox" name="auth" value="1">
                    <span><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_LABEL; ?></span>
                </label>
                <section class="auth w3-hide">
                    <label><b><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_USERNAME_LABEL; ?> <span class="w3-text-red">*</span></b>
                        <input class="w3-input w3-border w3-margin-bottom" type="text" name="username" autocomplete="off" placeholder="<?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_USERNAME_PLACEHOLDER; ?>" maxlength="255">
                    </label>
                    <label><b><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_PASSWORD_LABEL; ?> <span class="w3-text-red">*</span></b>
                        <input class="w3-input w3-border w3-margin-bottom" type="password" name="password" placeholder="<?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_PASSWORD_PLACEHOLDER; ?>" maxlength="255">
                    </label>
                </section>
                <div class="w3-bar">
                    <button class="test-smtp-settings w3-button w3-right w3-theme-action" type="button"><i class="fa fa-check-circle-o fa-lg"></i> <?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_SMTP_TEST_BUTTON_LABEL; ?></button>
                </div>
            </section>
            <div class="w3-padding"></div>
            <h3 class="w3-text-theme w3-border-bottom w3-border-theme"><i class="fa fa-pencil-square-o"></i> <?php echo MOD_Z4M_EMAILSENDING_SETTINGS_OPTIONS_TITLE; ?></h3>
            <label class="w3-show-block w3-margin-bottom">
                <input class="w3-check" type="checkbox" name="is_sending_enabled" value="1">
                <span><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_OPTIONS_SENDING_LABEL; ?></span>
            </label>
            <label class="w3-show-block w3-margin-bottom">
                <input class="w3-check" type="checkbox" name="is_history_enabled" value="1">
                <span><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_OPTIONS_HISTORY_LABEL; ?></span>
            </label>
            <label class="w3-show-block w3-margin-bottom">
                <input class="w3-check" type="checkbox" name="is_debug_enabled" value="1">
                <span><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_OPTIONS_SMTP_DEBUG_LABEL . MOD_Z4M_EMAILSENDING_SMTP_DEBUG_LEVEL; ?> (<i>emails_sent.log</i>)</span>
            </label>
            <div class="w3-padding"></div>
            <button class="w3-button w3-block w3-green w3-section" type="submit"><i class="fa fa-save fa-lg"></i> <?php echo LC_BTN_SAVE; ?></button>
        </section>
    </form>
    <footer class="w3-container w3-border-top w3-border-theme w3-padding-16 w3-theme-l4">
        <div class="w3-bar">
            <button class="send-test-email w3-button w3-right w3-theme-action" type="button"><i class="fa fa-paper-plane-o fa-lg"></i> <?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SEND_TEST_EMAIL_BUTTON_LABEL; ?></button>
        </div>
    </footer>
</div>
<div id="z4m-email-sending-settings-send-test-email" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container w3-theme-dark">
            <a class="close w3-button w3-xlarge w3-hover-theme w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
            <h4>
                <i class="fa fa-paper-plane-o fa-lg"></i>
                <span class="title"><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SEND_TEST_EMAIL_BUTTON_LABEL; ?></span>
            </h4>
        </header>
        <form class="w3-container w3-theme-light" data-zdk-submit="Z4MEmailSendingCtrl:sendTestEmail">
            <div class="w3-section">
                <label><b><?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SEND_TEST_EMAIL_RECIPIENT_EMAIL_LABEL; ?></b>
                    <input class="w3-input w3-border w3-margin-bottom" type="email" name="recipient_email" required placeholder="<?php echo MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_EMAIL_PLACEHOLDER; ?>">
                </label>
            </div>
            <!-- Submit button -->
            <p class="w3-padding"></p>
            <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">
                <i class="fa fa-check-circle fa-lg"></i>&nbsp;
                <?php echo LC_BTN_VALIDATE; ?>
            </button>
        </form>
        <footer class="w3-container w3-border-top w3-border-theme w3-padding-16 w3-theme-l4">
            <button type="button" class="cancel w3-button w3-red">
                <i class="fa fa-close fa-lg"></i>&nbsp;
                <?php echo LC_BTN_CLOSE; ?>
            </button>
        </footer>
    </div>
</div>
<script>
    <?php if (CFG_DEV_JS_ENABLED) : ?>
    console.log("'z4m_email_sending_settings' ** For debug purpose **");
    <?php endif; ?>
    $(function(){
        const formObj = z4m.form.make('#z4m-email-sending-settings-form', submitCallback),
            formEl = formObj.element[0];
        formObj.load(0, function(response){
            toggleFormSection('section.smtp', response.is_smtp === '1');
            toggleFormSection('section.auth', response.auth === '1');
        });
        formEl.addEventListener('change', function(event) {
            if (event.target.name === 'is_smtp') {
                toggleFormSection('section.smtp', event.target.value === '1');
            } else if (event.target.name === 'auth') {
                toggleFormSection('section.auth', event.target.checked);
            }
        });
        const container = document.getElementById('z4m-email-sending-settings-container');
        container.addEventListener('click', function(event) {
            const button = event.target.closest('button');
            if (button) {
                if (button.classList.contains('send-test-email')) {
                    showSendTestEmailModal();
                } else if (button.classList.contains('test-smtp-settings')) {
                    testSMTPConnection();
                }
            }
        });
        function submitCallback(response) {
            if (response.success) {
                formObj.setDataModifiedState(false);
            }
        }
        function toggleFormSection(selector, isVisible) {
            if (isVisible) {
                formEl.querySelector(selector).classList.remove('w3-hide');
            } else {
                formEl.querySelector(selector).classList.add('w3-hide');
            }
        }
        function showSendTestEmailModal() {
            if (formObj.isModified()) {
                formObj.showError(formEl.dataset.notsaved);
                return;
            }
            const modal = z4m.modal.make('#z4m-email-sending-settings-send-test-email');
            modal.open(function(){
                modal.getInnerForm().setDataModifiedState(false);
            });
        }
        function testSMTPConnection() {
            if (formObj.isModified()) {
                formObj.showError(formEl.dataset.notsaved);
                return;
            }
            z4m.ajax.request({
                controller: 'Z4MEmailSendingCtrl',
                action: 'testSMTPConnection',
                callback: function(response) {
                    z4m.messages.notify(response.summary, response.msg);
                }
            });
        }
    });
</script>