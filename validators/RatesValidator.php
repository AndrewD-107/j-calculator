<?php

namespace jcalculator\validators;

class RatesValidator
{
	public function validate($rates)
	{
		if (!$this->validateStages($rates)) throw new \Exception('Should be only 3 stages and contains indexes 1, 2, 3');
		for ($i = 1; $i <= count($rates); $i++) {
			if (!$this->validateVoltage($rates[$i]))
				throw new \Exception('Error in stage '.$i.'; Should be only 4 voltages and contains indexes 1, 2, 3, 4 ');
			for ($j = 1; $j <= count($rates[$i]); $j++) {
				if (!$this->validateScheme($rates[$i][$j]))
					throw new \Exception('Error in stage '.$i.' voltage '.$j.'; Should be only 2 schemes and contains indexes "t" or "s"');
				if (!$this->validateValue($rates[$i][$j]['s']))
					throw new \Exception('Value of "s" scheme in stage '.$i.' voltage '.$j.' should be both numeric and larger 0');
				if (!$this->validateValue($rates[$i][$j]['t']))
					throw new \Exception('Value of "t" scheme in stage '.$i.' voltage '.$j.' should be both numeric and larger 0');
			}
		}
	}

	private function validateStages($rates)
	{
		return count($rates) === 3 && isset($rates[1]) && isset($rates[2]) && isset($rates[3]);
	}

	private function validateVoltage($voltages)
	{
		return count($voltages) === 4 && isset($voltages[1]) && isset($voltages[2]) && isset($voltages[3]) && isset($voltages[4]);
	}

	private function validateScheme($scheme)
	{
		return count($scheme) === 2 && isset($scheme['s']) && isset($scheme['t']);
	}

	private function validateValue($value)
	{
		return is_numeric($value) && $value >= 0;
	}
}