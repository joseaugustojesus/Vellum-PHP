<?php
require_once __DIR__ . "/vendor/autoload.php";


initSessionIfNotStarted();
loadEnv();
setDebugAsActive();
timezoneDefault();
bootstrap();
