<?php
/**
 * Plugin Name: VGT Dattrack: Sovereign Analytics Engine
 * Plugin URI: https://visiongaiatechnology.com
 * Description: Modularisierte High-Performance Analytics-Lösung (AES-256-GCM). Zero-Dependency UI.
 * Version: 1.4.0 (DIAMANT TIER - EXPORT KERNEL)
 * Author: VisionGaiaTechnology Intelligence System
 * License: AGPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/agpl-3.0.html
 * Text Domain: vgt-dattrack
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

define('VGT_DATTRACK_DIR', plugin_dir_path(__FILE__));
define('VGT_DATTRACK_URL', plugin_dir_url(__FILE__));

require_once VGT_DATTRACK_DIR . 'includes/class-crypto.php';
require_once VGT_DATTRACK_DIR . 'includes/class-collector.php';
require_once VGT_DATTRACK_DIR . 'includes/class-dashboard.php';
require_once VGT_DATTRACK_DIR . 'includes/class-aggregator.php';

final class VGT_Dattrack_Engine {

    public static function boot(): void {
        register_activation_hook(__FILE__, [self::class, 'system_genesis']);
        register_deactivation_hook(__FILE__, [self::class, 'system_halt']);
        
        // Tracking Endpoints
        add_action('wp_ajax_vgt_sync_pulse', ['VGT_Collector', 'intercept']);
        add_action('wp_ajax_nopriv_vgt_sync_pulse', ['VGT_Collector', 'intercept']);
        
        // Cron Engines
        add_action('vgt_dt_hourly_rollup', ['VGT_Aggregator', 'run_rollup']);
        add_action('vgt_dt_aegis_rotation', ['VGT_Crypto', 'execute_aegis_protocol']);
        
        // VGT SUPREME: Echte dedizierte Backend-Routen via admin-post.php
        add_action('admin_post_vgt_sync', ['VGT_Dashboard', 'process_live_sync']);
        add_action('admin_post_vgt_export_csv', ['VGT_Dashboard', 'stream_csv']);
        add_action('admin_post_vgt_export_pdf', ['VGT_Dashboard', 'render_print_view']);
        
        // UI Endpoints
        add_action('admin_menu', [self::class, 'construct_command_center']);
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_frontend_assets']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_backend_assets']);
        add_action('wp_footer', [self::class, 'inject_micro_consent_ui'], 9999);
        
        // DSGVO Opt-Out Node
        add_shortcode('vgt_dattrack_optout', [self::class, 'render_privacy_control_node']);
    }

    public static function system_genesis(): void {
        global $wpdb;
        VGT_Crypto::init_vault();

        $table_vault = $wpdb->prefix . 'vgt_dattrack_vault';
        $table_stats = $wpdb->prefix . 'vgt_dattrack_stats';
        $charset_collate = $wpdb->get_charset_collate();

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $sql_vault = "CREATE TABLE {$table_vault} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            ip_hash VARCHAR(64) NOT NULL,
            payload LONGTEXT NOT NULL,
            iv VARCHAR(64) NOT NULL,
            auth_tag VARCHAR(64) NOT NULL,
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            KEY time_index (timestamp)
        ) $charset_collate;";

        $sql_stats = "CREATE TABLE {$table_stats} (
            stat_date DATE NOT NULL,
            events INT UNSIGNED NOT NULL DEFAULT 0,
            unique_users INT UNSIGNED NOT NULL DEFAULT 0,
            paths LONGTEXT NOT NULL,
            PRIMARY KEY  (stat_date)
        ) $charset_collate;";

        dbDelta($sql_vault);
        dbDelta($sql_stats);

        if (!wp_next_scheduled('vgt_dt_hourly_rollup')) {
            wp_schedule_event(time(), 'hourly', 'vgt_dt_hourly_rollup');
        }
        
        if (!wp_next_scheduled('vgt_dt_aegis_rotation')) {
            wp_schedule_event(time() + (30 * DAY_IN_SECONDS), 'monthly', 'vgt_dt_aegis_rotation');
        }
    }

    public static function system_halt(): void {
        wp_clear_scheduled_hook('vgt_dt_hourly_rollup');
        wp_clear_scheduled_hook('vgt_dt_aegis_rotation');
    }

    public static function construct_command_center(): void {
        add_menu_page(
            'VGT Dattrack Vault',
            'Dattrack',
            'manage_options',
            'vgt-dattrack',
            ['VGT_Dashboard', 'render_sovereign_dashboard'],
            'dashicons-shield',
            80
        );
    }

    public static function enqueue_frontend_assets(): void {
        if (is_admin()) return;
        wp_enqueue_style('vgt-dt-consent-css', VGT_DATTRACK_URL . 'assets/consent.css', [], '1.4.0');
        wp_enqueue_script('vgt-dt-consent-js', VGT_DATTRACK_URL . 'assets/consent.js', [], '1.4.0', true);

        wp_localize_script('vgt-dt-consent-js', 'vgtConfig', [
            'endpoint' => admin_url('admin-ajax.php')
        ]);
    }

    public static function enqueue_backend_assets(string $hook): void {
        if ($hook !== 'toplevel_page_vgt-dattrack') return;
        wp_enqueue_style('vgt-dt-dashboard-css', VGT_DATTRACK_URL . 'assets/dashboard.css', [], '1.4.0');
        wp_enqueue_script('vgt-dt-dashboard-js', VGT_DATTRACK_URL . 'assets/dashboard.js', [], '1.4.0', true);
        
        $metrics = VGT_Dashboard::get_vault_metrics();
        wp_localize_script('vgt-dt-dashboard-js', 'vgtDashboardData', [
            'metrics' => $metrics
        ]);
    }

    public static function inject_micro_consent_ui(): void {
        if (is_admin()) return;
        ?>
        <div id="vgt-dt-vault">
            <h4>VGT DATTRACK SENSOR</h4>
            <p>Wollen Sie helfen, anonyme Leistungsstatistiken zur Systemoptimierung zu sammeln? (End-to-End verschlüsselt)</p>
            <div class="vgt-dt-actions">
                <button class="vgt-btn vgt-btn-accept" id="vgt-dt-accept">Helfen</button>
                <button class="vgt-btn vgt-btn-deny" id="vgt-dt-deny">Nein danke</button>
            </div>
        </div>
        <?php
    }

    public static function render_privacy_control_node(): string {
        return '
        <div class="vgt-privacy-node" id="vgt-privacy-node">
            <div class="vgt-pn-header">
                <div class="vgt-pn-indicator" id="vgt-pn-indicator"></div>
                <div class="vgt-pn-info">
                    <span class="vgt-pn-title">VGT Telemetry Control</span>
                    <span class="vgt-pn-status" id="vgt-pn-status">Initialisiere Krypto-State...</span>
                </div>
            </div>
            <button class="vgt-pn-btn" id="vgt-pn-toggle-btn" disabled>Bitte warten</button>
        </div>';
    }
}

VGT_Dattrack_Engine::boot();