<?php

namespace jcalculator\handlers;

abstract class Handler
{
	protected $response;
	protected $params;
	protected $message;
	protected $messageType; // 1 - error, 2 - warning, 3 - info
	protected $filename;

	public function __get($attr)
	{
		switch ($attr) {
			case 'response': return $this->getResponse();
		}
	}

	public function getResponse()
	{
		return $this->response;
	}

	public function request($params=[])
	{
		$this->params = $params;
		$this->init();
	}

	protected function init()
	{
		$this->filename = $this->getFilename();
	}

	protected function formateResponse()
	{
		$this->response['messageType'] = $this->messageType ? $this->messageType : 0;
		$this->response['message'] = $this->message ? $this->message : null;
	}

	protected function getFilename()
	{
		switch ($this->params['settlementType']) {
			case 1: return dirname(__DIR__).'/rates/t'.$this->params['reliabilityCategory'].'.json';
			case 2: return dirname(__DIR__).'/rates/v'.$this->params['reliabilityCategory'].'.json';
		}
	}
}