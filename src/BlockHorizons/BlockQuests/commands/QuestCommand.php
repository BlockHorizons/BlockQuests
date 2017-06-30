<?php

namespace BlockHorizons\BlockQuests\commands;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\commands\quest_parameters\QuestCreateParameter;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class QuestCommand extends BlockQuestsCommand {

	public function __construct(BlockQuests $plugin) {
		parent::__construct($plugin, "quest", "Main quest command for BlockQuests", "/quest [parameter]", ["q"]);
	}

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

		}
	}
}