<?php

namespace BlockHorizons\BlockQuests;

use BlockHorizons\BlockQuests\gui\GuiHandler;
use pocketmine\plugin\PluginBase;

class BlockQuests extends PluginBase {

	private $guiHandler;

	public function onEnable() {
		$this->saveDefaultConfig();
		$this->guiHandler = new GuiHandler($this);
	}

	/**
	 * @return GuiHandler
	 */
	public function getGuiHandler(): GuiHandler {
		return $this->guiHandler;
	}
}