<?php

/*
Plugin Name:    WP Admin Booster
Plugin URI:     https://ondics.de/
Description:    Customer Support Ondics GmbH
Version:        1.1.3
Author:         ondics.de
Author URI:     https://ondics.de/
Text Domain:    ondics
License:        GPL2

WP Admin Booster is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

WP Admin Booster is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

/**
 * Ondics Function einbinden
 */
require_once plugin_dir_path(__FILE__) . 'functions/ondics-functions.php';
add_action('wp_enqueue_scripts', 'ondicsRegisterPluginStyles'); // css einbinden
add_action('admin_menu', 'ondicsMenu'); // Menüeintrag Admin Panel hinzufügen
add_action('wp_dashboard_setup', 'ondicsDashboardWidgets'); // Dashboard Widget Ondics
add_action('admin_init', 'ondicsSettingsInit'); //  Ondics Einstellungen
add_action('admin_enqueue_scripts', 'adminStyle'); // Admin Style anpassen

add_shortcode('email', 'ondicsEmailObfuscation'); // Shortcode für Email-Obfuscation
//Danach den Short-Code im HTML Text verwenden z.B [email]test@mail.test[/email]

add_shortcode('opt-out', 'matomoOptOut'); // Shortcode für Matomo Opt-Out
//Danach den Short-Code im HTML Text verwenden z.B [opt-out height="200" width="100"]

/**
 * Matomo Tracking Code, wenn konfiguriert
 * Fall 1: plugin installiert, aber nicht save in Einstellungen gemacht, noch nie save
 * Fall 2: save gemacht
*/
$options = get_option('ondicsSettings');
if ($options && trim($options['ondicsMatomoId']) != "" // Überprüft ob $options Werte hat und ob ein Wert kein leerer String ist
    && preg_match('/^[0-9]+$/', $options['ondicsMatomoId']) // Überprüft ob die ID nur Zahlen enthält
) {
        add_action('wp_head', 'ondicsMatomo');
}

if ($options && $options['ondicsCheckboxCookieBarAktivieren'] == "1") { // Prüft ob Cookie-Bar aktiviert ist
    add_action('wp_footer', 'ondicsShowCookieBar'); // Fügt Script zur Anzeige des Cookie-Bar in footer.php ein
}
