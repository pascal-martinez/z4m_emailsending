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
 * ZnetDK 4 Mobile Email Sending Module French translations
 *
 * File version: 1.0
 * Last update: 05/23/2024
 */

define('MOD_Z4M_EMAILSENDING_PARENT_MENU_LABEL', 'Envoi d\'emails');

/* History */
define('MOD_Z4M_EMAILSENDING_HISTORY_MENU_LABEL', 'Emails envoyés');
define('MOD_Z4M_EMAILSENDING_HISTORY_FILTER_STATUS_ALL', 'TOUS');
define('MOD_Z4M_EMAILSENDING_HISTORY_FILTER_PERIOD', 'Période');
define('MOD_Z4M_EMAILSENDING_HISTORY_PURGE_BUTTON_LABEL', 'Purger...');
define('MOD_Z4M_EMAILSENDING_HISTORY_PURGE_CONFIRMATION_TEXT', 'Confirmez-vous la purge de l\'historique ?');
define('MOD_Z4M_EMAILSENDING_HISTORY_PURGE_SUCCESS', 'Purge de l\'historique réussie.');
define('MOD_Z4M_EMAILSENDING_HISTORY_DATETIME_LABEL', 'Date heure d\'envoi');
define('MOD_Z4M_EMAILSENDING_HISTORY_DATETIME_SHORT_LABEL', 'Date :');
define('MOD_Z4M_EMAILSENDING_HISTORY_SENDER_LABEL', 'Emetteur');
define('MOD_Z4M_EMAILSENDING_HISTORY_SENDER_FROM_LABEL', 'De :');
define('MOD_Z4M_EMAILSENDING_HISTORY_RECIPIENTS_LABEL', 'Destinataires');
define('MOD_Z4M_EMAILSENDING_HISTORY_RECIPIENTS_TO_LABEL', 'A :');
define('MOD_Z4M_EMAILSENDING_HISTORY_RECIPIENTS_CC_LABEL', 'Cc :');
define('MOD_Z4M_EMAILSENDING_HISTORY_RECIPIENTS_BCC_LABEL', 'Cci :');
define('MOD_Z4M_EMAILSENDING_HISTORY_MESSAGE_LABEL', 'Message');
define('MOD_Z4M_EMAILSENDING_HISTORY_SUBJECT_LABEL', 'Objet :');
define('MOD_Z4M_EMAILSENDING_HISTORY_ATTACHMENTS_LABEL', 'Pièces jointes :');
define('MOD_Z4M_EMAILSENDING_HISTORY_SEE_EMAIL_LABEL', 'Voir l\'email');
define('MOD_Z4M_EMAILSENDING_HISTORY_STATUS_LABEL', 'Statut');

/* Settings*/
define('MOD_Z4M_EMAILSENDING_SETTINGS_MENU_LABEL', 'Config. envoi emails');
define('MOD_Z4M_EMAILSENDING_SETTINGS_TITLE', 'Configuration de l\'envoi des emails');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_TITLE', 'Emetteur des emails');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_NAME_LABEL', 'Nom de l\'émetteur');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_NAME_PLACEHOLDER', 'Par exemple : John DOE');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_EMAIL_LABEL', 'Email de l\'émetteur');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SENDER_EMAIL_PLACEHOLDER', 'Par exemple : johndoe@myemail.com');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_TITLE', 'Serveur d\'envoi des emails');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_LOCAL_LABEL', 'Local');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_SMTP_LABEL', 'SMTP');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_HOST_LABEL', 'Adresse du serveur');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_HOST_PLACEHOLDER', 'Par exemple : smtp.myhosting.com');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_PORT_LABEL', 'Port TCP/IP');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_PORT_PLACEHOLDER', 'Par exemple : 25, 465, 587');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_SECURITY_LABEL', 'Protocole sécurité');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_SECURITY_SSL_LABEL', 'SSL');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_SECURITY_TLS_LABEL', 'TLS');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_LABEL', 'Authentification');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_USERNAME_LABEL', 'Utilisateur');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_USERNAME_PLACEHOLDER', 'Nom de compte utilisateur déclaré sur le serveur de messagerie');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_PASSWORD_LABEL', 'Mot de passe');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_AUTH_PASSWORD_PLACEHOLDER', 'Mot de passe du compte utilisateur');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SERVER_SMTP_TEST_BUTTON_LABEL', 'Tester la connexion au serveur SMTP');
define('MOD_Z4M_EMAILSENDING_SETTINGS_OPTIONS_TITLE', 'Options');
define('MOD_Z4M_EMAILSENDING_SETTINGS_OPTIONS_SENDING_LABEL', 'Envoi des emails activé');
define('MOD_Z4M_EMAILSENDING_SETTINGS_OPTIONS_HISTORY_LABEL', 'Historique des emails envoyés');
define('MOD_Z4M_EMAILSENDING_SETTINGS_OPTIONS_SMTP_DEBUG_LABEL', 'Débogage des envois SMTP niveau ');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SEND_TEST_EMAIL_BUTTON_LABEL', 'Envoyer un email de test...');
define('MOD_Z4M_EMAILSENDING_SETTINGS_FORM_NOT_SAVED_MESSAGE', 'Veuillez enregistrer vos modifications avant de réaliser cette action.');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SEND_TEST_EMAIL_RECIPIENT_EMAIL_LABEL', 'Adresse email du destinataire');

define('MOD_Z4M_EMAILSENDING_SETTINGS_STORAGE_SUCCESS', 'Configuration enregistrée avec succès.');
define('MOD_Z4M_EMAILSENDING_SETTINGS_STORAGE_FAILED', 'Echec d\'enregistrement. Erreur : ');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SMTP_CONNECTION_TEST_SUCCESS', 'BRAVO ! La connexion au serveur SMTP a réussi.');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SMTP_CONNECTION_TEST_FAILED', 'ECHEC ! La connexion au serveur SMTP a échoué');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SEND_TEST_EMAIL_SUCCESS', 'Envoi réussi de l\'email de test');
define('MOD_Z4M_EMAILSENDING_SETTINGS_SEND_TEST_EMAIL_FAILED', 'L\'envoi de l\'email de test a échoué.');
