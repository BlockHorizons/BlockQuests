<?php

declare(strict_types = 1);

namespace BlockHorizons\BlockQuests\commands\quest_parameters;

use BlockHorizons\BlockQuests\BlockQuests;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class QuestResetParameter extends BaseParameter {

	public function __construct(BlockQuests $plugin, CommandSender $sender, array $args) {
		parent::__construct($plugin, $sender, $args);
	}

	/**
	 * @return bool
	 */
	public function perform(): bool {
		if(!$this->sender->hasPermission("blockquests.command.reset.self")) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] You do not have permission to use this command.");
			return true;
		}
		if(count($this->args) < 1 || count($this->args) > 2) {
			$this->sender->sendMessage(TextFormat::RED . "[Usage] /quest reset [player]");
			return true;
		}
		$player = $this->sender;
		if(isset($this->args[1])) {
			if(($player = $this->getPlugin()->getServer()->getPlayer($this->args[1])) === null) {
				$this->sender->sendMessage(TextFormat::RED . "[Error] The given player could not be found.");
				return true;
			}
			if(!$this->sender->hasPermission("blockquests.command.reset.others")) {
				$this->sender->sendMessage(TextFormat::RED . "[Error] You don't have permission to reset the quest data of other players.");
				return true;
			}
		}
		$this->getPlugin()->getPlayerDatabase()->clearData($player);
		$this->getPlugin()->getPlayerDatabase()->addPlayer($player);
		$this->sender->sendMessage(TextFormat::GREEN . "Quest data " . ($player !== $this->sender ? "of " . $player->getName() : null) . " reset successfully.");
		return true;
	}
}