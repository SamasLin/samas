<pre>
<?php
function build($name, $config, $parent)
{
	if (is_array($config)) {
		$path = $parent.'/'.$name;
		if (!file_exists($path)) {
			mkdir($path);
			chown($path, fileowner($_SERVER['DOCUMENT_ROOT']));
			chgrp($path, filegroup($_SERVER['DOCUMENT_ROOT']));
			echo 'mkdir: "'.$path.'"'.PHP_EOL;
		}
		foreach ($config as $key => $value) {
			build($key, $value, $path);
		}
	} else {
		$file_ext  = empty($config) ? '' : ".$config";
		$file_name = $parent.'/'.$name.$file_ext;
		if (!file_exists($file_name)) {
			file_put_contents($file_name, '');
			chown($file_name, fileowner($_SERVER['DOCUMENT_ROOT']));
			chgrp($file_name, filegroup($_SERVER['DOCUMENT_ROOT']));
			echo 'create file: "'.$file_name.'"'.PHP_EOL;
		}
	}
}
$construct = include 'init_config.php';
foreach ($construct as $key => $value) {
	build($key, $value, $_SERVER['DOCUMENT_ROOT']);
}
?>
</pre>