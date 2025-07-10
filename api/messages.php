<?php

require_once "../autoload.php";


header("Content-Type: application/json; charset=UTF-8");

(new MailingMap())->getMessages();
