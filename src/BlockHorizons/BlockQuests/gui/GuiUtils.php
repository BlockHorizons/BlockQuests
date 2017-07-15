<?php

declare(strict_types = 1);

namespace BlockHorizons\BlockQuests\gui;

use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\utils\TextFormat;

class GuiUtils {

	const WHITE = 0;
	const ORANGE = 1;
	const MAGENTA = 2;
	const LIGHT_BLUE = 3;
	const YELLOW = 4;
	const LIME = 5;
	const PINK = 6;
	const GREY = 7;
	const LIGHT_GREY = 8;
	const CYAN = 9;
	const PURPLE = 10;
	const BLUE = 11;
	const BROWN = 12;
	const GREEN = 13;
	const RED = 14;
	const BLACK = 15;

	const TYPE_CANCEL = 10;
	const TYPE_FINALIZE = 11;
	const TYPE_NEXT = 12;
	const TYPE_PREVIOUS = 13;

	const TYPE_ENTER_ITEMS = 1;
	const TYPE_ENTER_INT = 2;
	const TYPE_ENTER_TEXT = 3;
	const TYPE_ENTER_COMMANDS = 4;

	const MODE_QUEST_NAME = "questName";
	const MODE_QUEST_DESCRIPTION = "questDescription";
	const MODE_START_EXPERIENCE_LEVEL = "startExperienceLevel";
	const MODE_START_REQUIRED_ITEMS = "startRequiredItems";
	const MODE_REWARD_COMMANDS = "rewardCommands";
	const MODE_FINISH_REQUIRED_ITEMS = "finishRequiredItems";

	const MODE_STARTING_MESSAGE = "startingMessage";
	const MODE_FINISHING_MESSAGE = "finishingMessage";
	const MODE_STARTED_MESSAGE = "startedMessage";
	const MODE_FINISHED_MESSAGE = "finishedMessage";
	const MODE_INSUFFICIENT_START_EXPERIENCE_MESSAGE = "insufficientStartExperienceMessage";
	const MODE_MISSING_START_ITEMS_MESSAGE = "missingStartItemsMessage";

	/**
	 * @param int    $id
	 * @param string $customName
	 * @param array  $lore
	 * @param int    $type
	 * @param string $mode
	 *
	 * @return Item
	 */
	public static function item(int $id, string $customName, array $lore, int $type, string $mode = ""): Item {
		$item = Item::get(Item::WOOL, $id, 1);
		if(!empty($customName)) {
			$item->setCustomName(TextFormat::GREEN . $customName);
		}
		if(!empty($lore)) {
			$item->setLore($lore);
		}
		$nbt = $item->getNamedTag() ?? new CompoundTag("", []);
		$nbt->bqGuiInputType = new IntTag("bqGuiInputType", $type);
		$nbt->bqGuiInputMode = new StringTag("bqGuiInputMode", $mode);
		$item->setNamedTag($nbt);
		return $item;
	}
}