<?php
require_once __DIR__ . '/config/session.php';

session_unset();
session_destroy();

header("Location: auth_view.php");
exit;