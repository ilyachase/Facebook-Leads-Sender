<?php

const DS = DIRECTORY_SEPARATOR;
const FORMATTER_MYSQL_DATETIME_FORMAT = 'php:Y-m-d H:i:s';
const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';
const DEFAULT_EMAIL_FROM = 'admin@clcdatahub.com';

const PARAMS_FB_APP_ID = 'app_id';
const PARAMS_FB_APP_SECRET = 'app_secret';
const PARAMS_FB_SCOPES = 'scopes';
const PARAMS_CONNECTIONS_CHECK_INTERVALS = 'params_connections_check_intervals';
const PARAMS_CONNECTIONS_CHECK_INTERVALS_EVERY_MINUTE = 1;
const PARAMS_CONNECTIONS_CHECK_INTERVALS_EVERY_TEN_MINUTES = 10;
const PARAMS_CONNECTIONS_CHECK_INTERVALS_ONCE_PER_HOUR = 60;
const PARAMS_CONNECTIONS_CHECK_INTERVALS_ONCE_A_DAY = 1440;

return [
    PARAMS_FB_APP_ID                   => '109433556350716',
    PARAMS_FB_APP_SECRET               => '22e9f275cbca86c39b8f51af404ae779',
    PARAMS_FB_SCOPES                   => [ 'ads_management', 'manage_pages', 'business_management' ],
    PARAMS_CONNECTIONS_CHECK_INTERVALS => [
        PARAMS_CONNECTIONS_CHECK_INTERVALS_EVERY_MINUTE      => 'Every minute',
        PARAMS_CONNECTIONS_CHECK_INTERVALS_EVERY_TEN_MINUTES => 'Every 10 minutes',
        PARAMS_CONNECTIONS_CHECK_INTERVALS_ONCE_PER_HOUR     => 'Once per hour',
        PARAMS_CONNECTIONS_CHECK_INTERVALS_ONCE_A_DAY        => 'Once a day',
    ],
];
