<?php
trait FileOutput
{

    private static function mkdir($path)
    {
        mkdir($path);
        chown($path, fileowner(SITE_ROOT));
        chgrp($path, filegroup(SITE_ROOT));
    }// end function mkdir

    private static function file_put_contents($path, $content)
    {
        $result = file_put_contents($path, $content);
        chown($path, fileowner(SITE_ROOT));
        chgrp($path, filegroup(SITE_ROOT));
        return $result;
    }// end function file_put_contents

}
