<?php

use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/../.env')) {
  $_dotenv = Dotenv::create(__DIR__ . '/../');
  $_dotenv->load();
  unset($_dotenv);
}
