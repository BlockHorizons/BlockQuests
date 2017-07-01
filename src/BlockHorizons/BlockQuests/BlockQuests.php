<?php

namespace BlockHorizons\BlockQuests;

use BlockHorizons\BlockQuests\commands\BlockQuestsCommand;
use BlockHorizons\BlockQuests\commands\QuestCommand;
use BlockHorizons\BlockQuests\gui\GuiHandler;
use BlockHorizons\BlockQuests\listeners\GuiListener;
use pocketmine\plugin\PluginBase;

class BlockQuests extends PluginBase {

	private $guiHandler;

	public function onEnable() {
		$this->saveDefaultConfig();
		$this->registerCommands();
		$this->registerListeners();

		$this->guiHandler = new GuiHandler($this);
	}

	public function registerCommands() {
		$commands = [
			new QuestCommand($this)
		];
		/** @var BlockQuestsCommand $command */
		foreach($commands as $command) {
			$this->getServer()->getCommandMap()->register($command->getName(), $command);
		}
	}

	public function registerListeners() {
		$listeners = [
			new GuiListener($this)
		];
		foreach($listeners as $listener) {
			$this->getServer()->getPluginManager()->registerEvents($listener, $this);
		}
	}

	/**
	 * @return GuiHandler
	 */
	public function getGuiHandler(): GuiHandler {
		return $this->guiHandler;
	}
}