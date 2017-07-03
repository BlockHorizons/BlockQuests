<?php

namespace BlockHorizons\BlockQuests\commands\quest_parameters;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\gui\types\QuestCreatingGui;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class QuestCreateParameter extends BaseParameter {

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
		if(!$this->sender->hasPermission("blockquests.command.create")) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] You do not have permission to use this command.");
			return true;
		}
		if(count($this->args) < 2 || count($this->args) > 2) {
			$this->sender->sendMessage(TextFormat::RED . "[Usage] /quest create <ID>");
			return true;
		}
		if(!is_numeric($this->args[1])) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] The quest ID should be numeric.");
			return true;
		}
		if($this->getPlugin()->getGuiHandler()->isUsingGui($this->sender)) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] You are already creating a quest.");
			return true;
		}
		if($this->getPlugin()->getQuestManager()->questExists((int) $this->args[1])) {
			$this->sender->sendMessage(TextFormat::RED . "[Error] A quest with that quest ID already exists. Use \'/quest edit " . $this->args[1] . "\' to edit it.");
			return true;
		}
		$gui = new QuestCreatingGui($this->getPlugin(), $this->sender, (int) $this->args[1]);
		$gui->openGui();
		return true;
	}
}