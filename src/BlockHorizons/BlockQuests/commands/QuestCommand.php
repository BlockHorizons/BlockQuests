<?php

namespace BlockHorizons\BlockQuests\commands;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\commands\quest_parameters\QuestCreateParameter;
use BlockHorizons\BlockQuests\commands\quest_parameters\QuestEditParameter;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class QuestCommand extends BlockQuestsCommand {

	public function __construct(BlockQuests $plugin) {
		parent::__construct($plugin, "blockquest", "Main quest command for BlockQuests", "/blockquest [parameter]", ["bq"]);
	}

	/**
	 * @param CommandSender $sender
	 * @param string        $commandLabel
	 * @param array         $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, $commandLabel, array $args): bool {
		if(count($args) < 1) {
			$sender->sendMessage(TextFormat::RED . "[Usage] " . $this->getUsage());
			return true;
		}
		switch($args[0]) {
			case "create":
			case "make":
			case "new":
				return (new QuestCreateParameter($this->getPlugin(), $sender, $args))->perform();
			case "edit":
			case "modify":
				return (new QuestEditParameter($this->getPlugin(), $sender, $args))->perform();
		}
		return false;
	}
}