<?php
$localTelegramConfig = __DIR__ . '/telegram_config.local.php';

if (is_file($localTelegramConfig)) {
    require $localTelegramConfig;
}

if (!defined('TELEGRAM_BOT_TOKEN')) {
    define('TELEGRAM_BOT_TOKEN', '');
}

if (!defined('TELEGRAM_CHAT_ID')) {
    define('TELEGRAM_CHAT_ID', '');
}

if (!defined('TELEGRAM_ALERT_COOLDOWN_SECONDS')) {
    define('TELEGRAM_ALERT_COOLDOWN_SECONDS', 300);
}
