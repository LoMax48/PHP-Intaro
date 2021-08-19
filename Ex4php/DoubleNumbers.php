<?php

echo preg_replace_callback("#'(\d+)'#", function ($matches) {
    return  "'" . $matches[1] * 2 . "'";
}, $_GET['str']);
