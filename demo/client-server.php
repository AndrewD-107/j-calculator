<?php

require_once('../handlers/Handler.php');
require_once('../handlers/ClientHandler.php');
require_once('../Controller.php');

echo \jcalculator\Controller::getUser('client')->request($_POST)->calculate()->response;