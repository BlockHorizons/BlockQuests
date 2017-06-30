<?php

namespace BlockHorizons\BlockQuests;

use pocketmine\plugin\PluginBase;

class BlockQuests extends PluginBase {

	public function onEnable() {
		$this->saveDefaultConfig();
	}
}