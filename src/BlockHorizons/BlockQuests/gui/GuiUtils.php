<?php

namespace BlockHorizons\BlockQuests\gui;

use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
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

	const TYPE_CANCEL = 0;
	const TYPE_FINALIZE = 10;

	const TYPE_ENTER_ITEMS = 1;
	const TYPE_ENTER_INT = 2;
	const TYPE_ENTER_TEXT = 3;

	/**
	 * @param int    $id
	 * @param string $customName
	 * @param array  $lore
	 * @param int    $type
	 *
	 * @return Item
	 */
	public static function item(int $id, string $customName, array $lore, int $type): Item {
		$item = Item::get(Item::WOOL, $id, 1);
		if(!empty($customName)) {
			$item->setCustomName(TextFormat::GREEN . $customName);
		}
		if(!empty($lore)) {
			$item->setLore($lore);
		}
		$nbt = $item->getNamedTag() ?? new CompoundTag("", []);
		$nbt->bqGuiType = $type;
		$item->setNamedTag($nbt);
		return $item;
	}
}