<?php

namespace BlockHorizons\BlockQuests\commands;

use BlockHorizons\BlockQuests\BlockQuests;
use pocketmine\command\Command;
use pocketmine\command\PluginIdentifiableCommand;

abstract class BlockQuestsCommand extends Command implements PluginIdentifiableCommand {

	/** @var BlockQuests */
	protected $plugin;

	public function __construct(BlockQuests $plugin, $name, $description = "", $usageMessage = null, $aliases = []) {
		parent::__construct($name, $description, $usageMessage, $aliases);
		$this->setPermission("blockquests.command." . $name);
		$this->plugin = $plugin;
	}

	/**
	 * @return BlockQuests
	 */
	public function getPlugin(): BlockQuests {
		return $this->plugin;
	}
}