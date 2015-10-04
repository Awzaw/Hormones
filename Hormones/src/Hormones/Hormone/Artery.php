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

use Hormones\HormonesPlugin;
use pocketmine\scheduler\PluginTask;

class Artery extends PluginTask{
	/** @var Blood|null */
	private $lastBlood;
	public function onRun($currentTick){
		if($this->lastBlood !== null and !$this->lastBlood->queryFinished){
			return;
		}
		/** @var HormonesPlugin $owner */ // ASSERTION!
		$owner = $this->getOwner();
		$this->lastBlood = new Blood($owner);
		$owner->getServer()->getScheduler()->scheduleAsyncTask($this->lastBlood);
	}
}
