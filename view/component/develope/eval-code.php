<?php
if (substr($code, 0, 5) == '<?php') {
    $code = substr($code, 5);
} else if (substr($code, 0, 2) == '<?') {
    $code = substr($code, 2);
}
eval($code);
?>