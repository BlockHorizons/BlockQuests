<?php

namespace BlockHorizons\BlockQuests\gui\types;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\gui\GuiUtils;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class QuestEditingGui extends QuestCreatingGui {

	protected $initMessage = TF::GREEN . "Quest editing process started.";
	protected $finishMessage = TF::GREEN . "Quest editing process has been ended.";

	public function __construct(BlockQuests $plugin, Player $player) {
		parent::__construct($plugin, $player);
		$this->defaults["static"][0] = GuiUtils::item(GuiUtils::RED, "Cancel", ["Cancels the editing of this quest"], GuiUtils::TYPE_CANCEL);
		$this->defaults["static"][1] = GuiUtils::item(GuiUtils::LIME, "Save", ["Saves this quest and finalizes input data"], GuiUtils::TYPE_FINALIZE);
	}
}