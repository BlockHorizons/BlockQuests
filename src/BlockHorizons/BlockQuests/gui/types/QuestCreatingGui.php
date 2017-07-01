<?php

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

	public function __construct(BlockQuests $plugin, Player $player) {
		parent::__construct($plugin, $player);
		$this->defaults = [
			"static" => [
				0 => GuiUtils::item(GuiUtils::RED, "Cancel", ["Cancels the progress of creating this quest"], GuiUtils::TYPE_CANCEL),
				1 => GuiUtils::item(GuiUtils::LIME, "Finalize", ["Finalizes this quest to process all input data"], GuiUtils::TYPE_FINALIZE),
				2 => Item::get(Item::AIR),
				3 => GuiUtils::item(GuiUtils::WHITE, "Previous", ["Goes to the previous page"], GuiUtils::TYPE_PREVIOUS),
				8 => GuiUtils::item(GuiUtils::WHITE, "Next", ["Goes to the next page"], GuiUtils::TYPE_NEXT)
			],
			"dynamic" => [
				[
					4 => GuiUtils::item(GuiUtils::CYAN, "Quest Name", ["The name the quest will have"], GuiUtils::TYPE_ENTER_TEXT),
					5 => GuiUtils::item(GuiUtils::ORANGE, "Quest Description", ["The description of the quest"], GuiUtils::TYPE_ENTER_TEXT),
					6 => GuiUtils::item(GuiUtils::GREEN, "Starting Message", ["The message shown on initial quest start"], GuiUtils::TYPE_ENTER_TEXT),
					7 => GuiUtils::item(GuiUtils::BLUE, "Started Message", ["The message shown when this quest has already been started"], GuiUtils::TYPE_ENTER_TEXT)
				],
				[
					4 => GuiUtils::item(GuiUtils::GREEN, "Finishing Message", ["The message shown when finishing this quest"], GuiUtils::TYPE_ENTER_TEXT),
					5 => GuiUtils::item(GuiUtils::GREEN, "Finished Message", ["The message shown when this quest has already been finished"], GuiUtils::TYPE_ENTER_TEXT),
					6 => GuiUtils::item(GuiUtils::YELLOW, "Required Starting Experience", ["The required experience level a player needs to start this quest"], GuiUtils::TYPE_ENTER_INT),
					7 => GuiUtils::item(GuiUtils::ORANGE, "Required Starting Items", ["The items required to start this quest"], GuiUtils::TYPE_ENTER_ITEMS)
				],
				[
					4 => GuiUtils::item(GuiUtils::PINK, "Required Finishing Items", ["The items required to finish this quest"], GuiUtils::TYPE_ENTER_ITEMS),
					5 => GuiUtils::item(GuiUtils::LIGHT_BLUE, "Reward Commands", ["The commands executed when finishing this quest"], GuiUtils::TYPE_ENTER_TEXT),
				]
			]
		];
	}

	private function send() {
		$this->previousContents = $this->player->getInventory()->getContents();
		for($i = 0; $i < $this->player->getInventory()->gethotBarSize(); $i++) {
			$this->player->getInventory()->clear($i);
		}
		foreach($this->defaults["static"] as $slot => $item) {
			$this->player->getInventory()->setItem($slot, $item);
		}
		foreach($this->defaults["dynamic"][0] as $slot => $item) {
			$this->player->getInventory()->setItem($slot, $item);
		}
	}

	/**
	 * @param int $pageNumber
	 *
	 * @return bool
	 */
	public function goToPage(int $pageNumber): bool {
		if($pageNumber < 1 || $pageNumber > count($this->defaults["dynamic"])) {
			return false;
		}
		for($i = 4; $i < 8; $i++) {
			$this->player->getInventory()->clear($i);
		}
		foreach($this->defaults["dynamic"][$pageNumber - 1] as $slot => $item) {
			$this->player->getInventory()->setItem($slot, $item);
		}
		$this->page = $pageNumber;
		return true;
	}

	public function openGui() {
		$this->send();
		$this->player->sendMessage($this->initMessage);
		$this->getPlugin()->getGuiHandler()->setUsingGui($this->player, true, $this);
	}

	/**
	 * @param bool $cancelled
	 */
	public function closeGui(bool $cancelled = true) {
		if(!$cancelled) {
			// Process input.
		}
		$this->player->getInventory()->setContents($this->previousContents);
		$this->getPlugin()->getGuiHandler()->setUsingGui($this->player, false, $this);
	}
}