<?php

namespace BlockHorizons\BlockQuests\gui\types;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\gui\BaseGui;
use BlockHorizons\BlockQuests\gui\GuiUtils;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class QuestCreatingGui extends BaseGui {

	protected $initMessage = TF::GREEN . "Quest creating process started.";
	protected $finishMessage = TF::GREEN . "Quest creating process has been ended.";

	public function __construct(BlockQuests $plugin, Player $player) {
		parent::__construct($plugin, $player);
		$this->defaults = [
			0 => GuiUtils::item(GuiUtils::RED, "Cancel", ["Cancels the progress of creating this quest"], GuiUtils::TYPE_CANCEL),
			1 => GuiUtils::item(GuiUtils::LIME, "Finalize", ["Finalizes this quest to process all input data"], GuiUtils::TYPE_FINALIZE),
			2 => GuiUtils::item(GuiUtils::YELLOW, "Required Starting Experience", ["The required experience level a player needs to start this quest"], GuiUtils::TYPE_ENTER_INT),
			3 => GuiUtils::item(GuiUtils::ORANGE, "Required Starting Items", ["The items required to start this quest"], GuiUtils::TYPE_ENTER_ITEMS),
			4 => GuiUtils::item(GuiUtils::RED, "Required Finishing Items", ["The items required to finish this quest"], GuiUtils::TYPE_ENTER_ITEMS),
			5 => GuiUtils::item(GuiUtils::LIGHT_BLUE, "Reward Commands", ["The commands executed when finishing this quest"], GuiUtils::TYPE_ENTER_TEXT),
			6 => GuiUtils::item(GuiUtils::LIGHT_GREY, "Starting Message", ["The message showed when starting this quest"], GuiUtils::TYPE_ENTER_TEXT),
			7 => GuiUtils::item(GuiUtils::BLUE, "Started Message", ["The message showed when this quest has already been started"], GuiUtils::TYPE_ENTER_TEXT),
			8 => GuiUtils::item(GuiUtils::GREEN, "Finishing Message", ["The message showed when finishing this quest"], GuiUtils::TYPE_ENTER_TEXT)
		];
	}

	private function send() {
		$this->previousContents = $this->player->getInventory()->getContents();
		foreach($this->defaults as $slot => $item) {
			$this->player->getInventory()->setItem($slot, $item);
		}
	}

	public function openGui() {
		$this->send();
		$this->player->sendMessage($this->initMessage);
		$this->getPlugin()->getGuiHandler()->setUsingGui($this->player, true, $this);
	}

	public function closeGui(bool $cancelled = true) {
		if(!$cancelled) {
			// Process input.
		}
		$this->player->getInventory()->setContents($this->previousContents);
		$this->getPlugin()->getGuiHandler()->setUsingGui($this->player, false, $this);
	}
}