<?php

if (file_exists(__DIR__ . '/../.env')) {
  $_dotenv = new Dotenv(__DIR__ . '/../');
  $_dotenv->load();
  unset($_dotenv);
}
