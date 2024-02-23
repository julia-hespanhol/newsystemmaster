<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

$path = __DIR__;
loadDotenvFile($path, ".env.local");
loadDotenvFile($path, ".env");

function loadDotenvFile($path, $filename)
{
    if (file_exists("{$path}/{$filename}")) {
        new \Fence\Dotenv($path, $filename);
    }
}
