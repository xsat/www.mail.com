<?php

namespace Backend;

class Module extends \Common\Module
{
	public function __construct()
	{
		$this->dir = __DIR__;
		$this->prefix = 'Backend';
	}
}
