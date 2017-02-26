<?php
include $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'system_config.php';
$request_parser = new RequestParser();
$request_parser->run();
