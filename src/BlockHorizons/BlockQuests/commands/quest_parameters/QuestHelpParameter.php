<?php

namespace BlockHorizons\BlockQuests\commands\quest_parameters;

use BlockHorizons\BlockQuests\BlockQuests;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as TF;

class QuestHelpParameter extends BaseParameter {

	public function __construct(BlockQuests $plugin, CommandSender $sender, array $args) {
		parent::__construct($plugin, $sender, $args);
	}

	/**
	 * @return bool
	 */
	public function perform(): bool {
		if(!$this->sender->hasPermission("blockquests.command.help.default")) {
			$this->sender->sendMessage(TF::RED . "[Error] You do not have permission to use this command.");
			return true;
		}
		if($this->sender->hasPermission("blockquests.command.help.operator")) {
			$this->sender->sendMessage(
				TF::GREEN . "/bq check <ID>: " . TF::YELLOW . "Checks the given quest to start or end it if possible." . PHP_EOL .
				TF::GREEN . "/bq create <ID>: " . TF::YELLOW . "Creates a new quest with the given ID and opens up the GUI." . PHP_EOL .
				TF::GREEN . "/bq delete <ID>: " . TF::YELLOW . "Deletes a quest with the given ID." . PHP_EOL .
				TF::GREEN . "/bq edit <ID>: " . TF::YELLOW . "Reopens the GUI of a quest to start editing it." . PHP_EOL .
				TF::GREEN . "/bq reset [Player]: " . TF::YELLOW . "Resets your quest data, or the data of a given player."
			);
		} else {
			$this->sender->sendMessage(
				TF::GREEN . "/bq check <ID>: " . TF::YELLOW . "Checks the given quest to start or end it if possible." . PHP_EOL .
				TF::GREEN . "/bq reset: " . TF::YELLOW . "Resets your quest data."
			);
		}
		return true;
	}
}