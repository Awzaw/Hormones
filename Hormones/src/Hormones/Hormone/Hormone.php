<?php

/*
 * Hormone
 *
 * Copyright (C) 2015 LegendsOfMCPE and contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author LegendsOfMCPE
 */

namespace Hormones\Hormone;

use Hormones\Event\HormoneReleaseEvent;
use Hormones\HormonesPlugin;

abstract class Hormone{
	/** @var HormonesPlugin */
	private $main;
	/** @var int */
	private $receptors;
	/** @var int */
	private $creationTime;
	/** @var mixed */
	private $data;
	/** @var string[] */
	private $tags;
	/** @var int|null */
	private $id;
	public function __construct(HormonesPlugin $main, int $receptors, int $creationTime, $data, array $tags = [], $id = null){
		$this->main = $main;
		$this->receptors = $receptors;
		$this->creationTime = $creationTime;
		$this->data = $data;
		$this->tags = $tags;
		$this->id = $id;
	}
	public function getTypeName() : string{
		return (new \ReflectionClass($this))->getShortName();
	}
	/**
	 * @return int
	 */
	public function getReceptors() : int{
		return $this->receptors;
	}
	/**
	 * @return int
	 */
	public function getCreationTime() : int{
		return $this->creationTime;
	}
	/**
	 * @return mixed
	 */
	public function getData(){
		return $this->data;
	}
	/**
	 * @return \string[]
	 */
	public function getTags() : array{
		return $this->tags;
	}
	/**
	 * @return int|null
	 */
	public function getId(){
		return $this->id;
	}
	/**
	 * @param int $id
	 */
	public function setId(int $id){
		$this->id = $id;
	}
	public function getMain() : HormonesPlugin{
		return $this->main;
	}

	public function release(){
		$this->getMain()->getServer()->getPluginManager()->callEvent($ev = new HormoneReleaseEvent($this->getMain(), $this));
		if(!$ev->isCancelled()){
			$this->getMain()->getServer()->getScheduler()->scheduleAsyncTask(new Vein($this));
		}
	}

	public abstract function execute();
}
