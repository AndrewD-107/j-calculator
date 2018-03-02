<?php

namespace jcalculator;

use jcalculator\handlers\ClientHandler;
use jcalculator\handlers\AdministratorHandler;

class Controller
{
	public static function getUser($role)
	{
		switch ($role) {
			case 'client': return new ClientHandler();
			case 'administrator': return new AdministratorHandler();
		}
	}
}