<?php

require_once('../../handlers/Handler.php');
require_once('../../handlers/AdministratorHandler.php');
require_once('../../validators/RatesValidator.php');
require_once('../../Controller.php');

if ($_POST && $_POST['method']) {
	switch ($_POST['method']) {
		case 'get': echo \jcalculator\Controller::getUser('administrator')->request($_POST)->ratesAsJson; break;
		case 'update': echo \jcalculator\Controller::getUser('administrator')->request($_POST)->updateRates()->response; break;
	}
}