<?php

namespace BlockHorizons\BlockQuests\commands\quest_parameters;

use BlockHorizons\BlockQuests\BlockQuests;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class QuestCheckParameter extends BaseParameter {

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
		if(!$this->sender->hasPermission("blockquests.command.check")) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] You do not have permission to use this command.");
			return true;
		}
		if(count($this->args) < 2 || count($this->args) > 2) {
			$this->sender->sendMessage(TextFormat::RED . "[Usage] /quest check <ID>");
			return true;
		}
		if(!is_numeric($this->args[1])) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] The quest ID should be numeric.");
			return true;
		}
		if(!$this->getPlugin()->getQuestManager()->questExists((int) $this->args[1])) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] A quest with that quest ID does not exist.");
			return true;
		}
		$quest = $this->getPlugin()->getQuestManager()->getQuestById((int) $this->args[1]);
		if(!$this->getPlugin()->getPlayerDatabase()->hasQuestStarted($this->sender, $quest->getId()) && !$this->getPlugin()->getPlayerDatabase()->hasQuestFinished($this->sender, $quest->getId())) {
			if(!$quest->checkStartingExperience($this->sender)) {
				$this->sender->sendMessage(TextFormat::RED . $quest->getInsufficientStartExperienceMessage());
				return true;
			}
			if(!$quest->checkStartingItems($this->sender)) {
				$this->sender->sendMessage(TextFormat::RED . $quest->getMissingStartItemsMessage());
				return true;
			}
			foreach($quest->getStartRequiredItems() as $item) {
				$this->sender->getInventory()->removeItem($item);
			}
			$this->getPlugin()->getQuestManager()->startQuest($quest, $this->sender);
		} elseif($this->getPlugin()->getPlayerDatabase()->hasQuestStarted($this->sender, $quest->getId())) {
			if(!$quest->checkFinishingItems($this->sender)) {
				$this->sender->sendMessage(TextFormat::YELLOW . $quest->getStartedMessage());
				return true;
			}
			foreach($quest->getFinishRequiredItems() as $item) {
				$this->sender->getInventory()->removeItem($item);
			}
			$this->getPlugin()->getQuestManager()->finishQuest($quest, $this->sender);
		} else {
			$this->sender->sendMessage($quest->getFinishedMessage());
		}

		return true;
	}
}