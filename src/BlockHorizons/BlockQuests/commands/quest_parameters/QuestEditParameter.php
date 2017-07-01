<?php

namespace BlockHorizons\BlockQuests\commands\quest_parameters;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\gui\types\QuestCreatingGui;
use BlockHorizons\BlockQuests\gui\types\QuestEditingGui;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class QuestEditParameter extends BaseParameter {

	public function __construct(BlockQuests $plugin, CommandSender $sender, array $args) {
		parent::__construct($plugin, $sender, $args);
	}

	/**
	 * @return bool
	 */
	public function perform(): bool {
		if(!$this->sender instanceof Player) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] This command can only be executed as a player.");
			return true;
		}
		if(count($this->args) < 2 || count($this->args) > 2) {
			$this->sender->sendMessage(TextFormat::RED . "[Usage] /quest edit <ID>");
			return true;
		}
		if(!is_numeric($this->args[1])) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] The quest ID should be numeric.");
			return true;
		}
		$gui = new QuestEditingGui($this->getPlugin(), $this->sender);
		$gui->openGui();
		return true;
	}
}