<?php
require $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'system_config.php';
@include $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'global_function.php';
// $request_parser = new RequestParser();
// $request_parser->run();
echo '<pre>';
print_r(get_defined_constants());