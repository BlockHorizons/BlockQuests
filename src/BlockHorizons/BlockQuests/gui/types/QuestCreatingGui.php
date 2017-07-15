<?php

declare(strict_types = 1);

namespace BlockHorizons\BlockQuests\gui\types;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\gui\BaseGui;
use BlockHorizons\BlockQuests\gui\GuiUtils;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class QuestCreatingGui extends BaseGui {

	protected $initMessage = TF::GREEN . "Quest creating process started.";
	protected $finishMessage = TF::GREEN . "Quest creating process has been ended.";

	public function __construct(BlockQuests $plugin, Player $player, int $questId) {
		parent::__construct($plugin, $player, $questId);
		$this->defaults = [
			"static" => [
				0 => GuiUtils::item(GuiUtils::RED, "Cancel", ["Cancels the progress of creating this quest"], GuiUtils::TYPE_CANCEL),
				1 => GuiUtils::item(GuiUtils::LIME, "Finalize", ["Finalizes this quest to process all input data"], GuiUtils::TYPE_FINALIZE),
				2 => Item::get(Item::AIR),
				3 => GuiUtils::item(GuiUtils::WHITE, "Previous", ["Goes to the previous page"], GuiUtils::TYPE_PREVIOUS),
				8 => GuiUtils::item(GuiUtils::WHITE, "Next", ["Goes to the next page"], GuiUtils::TYPE_NEXT)
			],
			"dynamic" => [
				0 => [
					4 => GuiUtils::item(GuiUtils::CYAN, "Quest Name", ["The name the quest will have"], GuiUtils::TYPE_ENTER_TEXT, GuiUtils::MODE_QUEST_NAME),
					5 => GuiUtils::item(GuiUtils::ORANGE, "Quest Description", ["The description of the quest"], GuiUtils::TYPE_ENTER_TEXT, GuiUtils::MODE_QUEST_DESCRIPTION),
					6 => GuiUtils::item(GuiUtils::GREEN, "Starting Message", ["The message shown on initial quest start"], GuiUtils::TYPE_ENTER_TEXT, GuiUtils::MODE_STARTING_MESSAGE),
					7 => GuiUtils::item(GuiUtils::BLUE, "Started Message", ["The message shown when this quest has already been started"], GuiUtils::TYPE_ENTER_TEXT, GuiUtils::MODE_STARTED_MESSAGE)
				],
				1 => [
					4 => GuiUtils::item(GuiUtils::GREEN, "Finishing Message", ["The message shown when finishing this quest"], GuiUtils::TYPE_ENTER_TEXT, GuiUtils::MODE_FINISHING_MESSAGE),
					5 => GuiUtils::item(GuiUtils::MAGENTA, "Finished Message", ["The message shown when this quest has already been finished"], GuiUtils::TYPE_ENTER_TEXT, GuiUtils::MODE_FINISHED_MESSAGE),
					6 => GuiUtils::item(GuiUtils::YELLOW, "Required Starting Experience", ["The required experience level a player needs to start this quest"], GuiUtils::TYPE_ENTER_INT, GuiUtils::MODE_START_EXPERIENCE_LEVEL),
					7 => GuiUtils::item(GuiUtils::ORANGE, "Required Starting Items", ["The items required to start this quest"], GuiUtils::TYPE_ENTER_ITEMS, GuiUtils::MODE_START_REQUIRED_ITEMS)
				],
				2 => [
					4 => GuiUtils::item(GuiUtils::PINK, "Required Finishing Items", ["The items required to finish this quest"], GuiUtils::TYPE_ENTER_ITEMS, GuiUtils::MODE_FINISH_REQUIRED_ITEMS),
					5 => GuiUtils::item(GuiUtils::LIGHT_BLUE, "Reward Commands", ["The commands executed when finishing this quest"], GuiUtils::TYPE_ENTER_COMMANDS, GuiUtils::MODE_REWARD_COMMANDS),
					6 => GuiUtils::item(GuiUtils::ORANGE, "Insufficient Experience Message", ["The message sent if the player has too little experience to start"], GuiUtils::TYPE_ENTER_TEXT, GuiUtils::MODE_INSUFFICIENT_START_EXPERIENCE_MESSAGE),
					7 => GuiUtils::item(GuiUtils::LIME, "Missing Starting Items Message", ["The message sent if the player does not have the required starting items"], GuiUtils::TYPE_ENTER_TEXT, GuiUtils::MODE_MISSING_START_ITEMS_MESSAGE)
				]
			]
		];
	}
}