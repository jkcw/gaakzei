<?php

session_start();
session_unset();
session_destroy();
header("Location: https://www.gaakzei.com?success=logout");
