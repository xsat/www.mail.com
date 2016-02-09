<?php

namespace Frontend;

class Module extends \Common\Module
{
	public function __construct()
	{
		$this->dir = __DIR__;
		$this->prefix = 'Frontend';
	}
}
