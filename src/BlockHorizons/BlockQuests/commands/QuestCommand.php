<?php

declare(strict_types = 1);

namespace BlockHorizons\BlockQuests\commands;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\commands\quest_parameters\QuestCheckParameter;
use BlockHorizons\BlockQuests\commands\quest_parameters\QuestCreateParameter;
use BlockHorizons\BlockQuests\commands\quest_parameters\QuestDeleteParameter;
use BlockHorizons\BlockQuests\commands\quest_parameters\QuestEditParameter;
use BlockHorizons\BlockQuests\commands\quest_parameters\QuestHelpParameter;
use BlockHorizons\BlockQuests\commands\quest_parameters\QuestResetParameter;
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
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
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
			case "delete":
			case "remove":
				return (new QuestDeleteParameter($this->getPlugin(), $sender, $args))->perform();
			case "check":
				return (new QuestCheckParameter($this->getPlugin(), $sender, $args))->perform();
			case "reset":
			case "clear":
				return (new QuestResetParameter($this->getPlugin(), $sender, $args))->perform();
			case "help":
				return (new QuestHelpParameter($this->getPlugin(), $sender, $args))->perform();
		}
		return false;
	}
}