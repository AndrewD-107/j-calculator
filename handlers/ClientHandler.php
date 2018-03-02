<?php

namespace jcalculator\handlers;

class ClientHandler extends Handler
{
	private $rates;

	public function __construct()
	{
		$this->formateResponse();
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
		}
		elseif (!isset($params['orderedEnergy'])) {
			$this->messageType = 1;
			$this->message = 'Не можливо визначити замовлену для приєднання потужність';
		}
		elseif (!isset($params['scheme'])) {
			$this->messageType = 1;
			$this->message = 'Не можливо визначити схему приєднання';
		}
		elseif (!isset($params['voltage'])) {
			$this->messageType = 1;
			$this->message = 'Не можливо визначити напругу приєднання';
		} else {
			parent::request($params);
		}
		return $this;
	}

	public function calculate()
	{
		if (!$this->messageType) {
			if ($this->params['orderedEnergy'] <= 16 && $this->params['orderedEnergy'] >= 0) $this->response = $this->calculateByStage(1);
			elseif ($this->params['orderedEnergy'] > 16 && $this->params['orderedEnergy'] <= 50) $this->response = $this->calculateByStage(2);
			elseif ($this->params['orderedEnergy'] > 50 && $this->params['orderedEnergy'] <= 160) $this->response = $this->calculateByStage(3);
			else $this->message = 'Замовлена потужність має бути в межах від 0 до 160 кВт';
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
			'value' => $this->response ? round($this->response, 2) : 0.00,
			'pdv' => $this->response ? round(($this->response * 1.2), 2) : 0.00,
			'message' => $this->message ? $this->message : null,
		]);
	}

	private function calculateByStage($stage)
	{
		switch ($this->params['scheme']) {
			case 1: return (double)$this->params['orderedEnergy'] * (double)$this->rates[$stage][$this->params['voltage']]['s'] * (double)1000.0;
			case 2: return (double)$this->params['orderedEnergy'] * (double)$this->rates[$stage][$this->params['voltage']]['t'] * (double)1000.0;
		}
	}
}