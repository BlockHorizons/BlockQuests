<?php

declare(strict_types = 1);

namespace BlockHorizons\BlockQuests\commands;

use BlockHorizons\BlockQuests\BlockQuests;
use pocketmine\command\Command;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;

abstract class BlockQuestsCommand extends Command implements PluginIdentifiableCommand {

	/** @var BlockQuests */
	protected $plugin;

	public function __construct(BlockQuests $plugin, string $name, string $description = "", string $usageMessage = "", array $aliases = []) {
		parent::__construct($name, $description, $usageMessage, $aliases);
		$this->plugin = $plugin;
	}

	/**
	 * @return BlockQuests
	 */
	public function getPlugin(): Plugin {
		return $this->plugin;
	}
}