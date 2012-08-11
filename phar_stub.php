<?php
if (in_array("phar", stream_get_wrappers()) && class_exists("Phar", 0)) {
    Phar::interceptFileFuncs();
    set_include_path("phar://" . __FILE__ . PATH_SEPARATOR . get_include_path());
    include "phar://" . __FILE__ . "/SwiftMailer/lib/swift_required.php";
    include "phar://" . __FILE__ . "/autoload.php";
    include "phar://" . __FILE__ . "/!inc.php";
    return;
} else {
    exit("You DO NOT have phar extension enabled. Read instructions here: http://www.php.net/manual/en/phar.setup.php Try again when you have phar extension setup properly.");
}

__HALT_COMPILER();
