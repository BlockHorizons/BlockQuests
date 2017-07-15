<?php

declare(strict_types = 1);

namespace BlockHorizons\BlockQuests\commands\quest_parameters;

use BlockHorizons\BlockQuests\BlockQuests;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class QuestDeleteParameter extends BaseParameter {

	public function __construct(BlockQuests $plugin, CommandSender $sender, array $args) {
		parent::__construct($plugin, $sender, $args);
	}

	/**
	 * @return bool
	 */
	public function perform(): bool {
		if(!$this->sender->hasPermission("blockquests.command.delete")) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] You do not have permission to use this command.");
			return true;
		}
		if(count($this->args) < 2 || count($this->args) > 2) {
			$this->sender->sendMessage(TextFormat::RED . "[Usage] /quest delete <ID>");
			return true;
		}
		if(!is_numeric($this->args[1])) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] The quest ID should be numeric.");
			return true;
		}
		$this->getPlugin()->getQuestManager()->deleteQuest((int) $this->args[1]);
		$this->sender->sendMessage(TextFormat::GREEN . "Quest with ID " . TextFormat::AQUA . (string) $this->args[1] . TextFormat::GREEN . " successfully deleted.");
		return true;
	}
}