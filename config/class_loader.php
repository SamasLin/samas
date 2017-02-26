<?php
function classAutoLoader($class_name) {
    $class_name = ltrim($class_name, '\\');
    $file_name  = '';
    $namespace  = '';
    if ($lastNsPos = strrpos($class_name, '\\')) {
        $namespace = substr($class_name, 0, $lastNsPos);
        $class_name = substr($class_name, $lastNsPos + 1);
        $file_name  = LIB_ROOT.DIRECTORY_SEPARATOR.
                      str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR.
                      str_replace('_', DIRECTORY_SEPARATOR, $class_name).'.php';
        require $file_name;
    } else {
        $scan_ignore = array(
            '.',
            '..'
        );
        $scandir = scandir(SITE_ROOT.DIRECTORY_SEPARATOR.'class');
        $folder_list = array_diff($scandir, $scan_ignore);
        foreach ($folder_list as $folder) {
            $folder_path = SITE_ROOT.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.$folder;
            if (is_dir($folder_path) && is_readable($folder_path)) {
                $file_name = $folder_path.DIRECTORY_SEPARATOR.$class_name.'.php';
                if (file_exists($file_name)) {
                    require $file_name;
                }
            }
        }
    }
}

spl_autoload_register('classAutoLoader');