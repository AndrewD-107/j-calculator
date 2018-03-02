<?php

namespace jcalculator\handlers;

use jcalculator\validators\RatesValidator;

class AdministratorHandler extends Handler
{
	private $rates;
	private $validator;

	public function __get($attr)
	{
		switch ($attr) {
			case 'ratesAsJson': return $this->getRatesAsJson();
			case 'rates': return $this->getRates();
			default: return parent::__get($attr);
		}
	}

	public function __construct()
	{
		$this->formateResponse();
		$this->validator = new RatesValidator();
	}

	public function getRates()
	{
		return $this->rates;
	}

	public function getRatesAsJson()
	{
		$this->response = [
			'messageType' => $this->messageType ? $this->messageType : null,
			'message' => $this->message ? $this->message: null,
			'rates' => $this->rates ? $this->rates : null
		];
		return json_encode($this->response);
	}

	public function request($params=[])
	{
		if (!isset($params['settlementType'])) {
			$this->messageType = 1;
			$this->message = 'Не можливо визначити тип населеного пункту';
		}
		elseif (!isset($params['reliabilityCategory'])) {
			$this->messageType = 1;
			$this->message = 'Не можливо визначити категорію надійності';
		} else {
			parent::request($params);
		}
		return $this;
	}

	public function updateRates()
	{
		if (!$this->messageType && $this->validateRates()) {
			file_put_contents($this->filename, json_encode($this->params['rates']));
			$this->rates = $this->params['rates'];
			$this->messageType = 3;
			$this->message = 'Ставки обновлено';
		}
		$this->formateResponse();
		return $this;
	}

	protected function init()
	{
		parent::init();
		$this->rates = json_decode(file_get_contents($this->filename), true);
	}

	protected function formateResponse()
	{
		$this->response = json_encode([
			'messageType' => $this->messageType ? $this->messageType : null,
			'message' => $this->message ? $this->message : null
		]);
	}

	private function validateRates()
	{
		try {
			if (!isset($this->params['rates'])) throw new \Exception('В запиті не вказані ставки для обновлення');
			else {
				$this->validator->validate($this->params['rates']);
			}
			return true;
		} catch (\Exception $e) {
			$this->messageType = 1;
			$this->message = $e->getMessage();
			return false;
		}
	}
}