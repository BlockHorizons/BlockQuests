<?php

declare(strict_types = 1);

namespace BlockHorizons\BlockQuests\quests;

use BlockHorizons\BlockQuests\gui\GuiUtils;

class QuestValidator {

	private $result;

	public function __construct(array $data) {
		if(
			!(isset($data[GuiUtils::MODE_REWARD_COMMANDS])) ||
			!(isset($data[GuiUtils::MODE_FINISH_REQUIRED_ITEMS])) ||
			!(isset($data[GuiUtils::MODE_START_EXPERIENCE_LEVEL])) ||
			!(isset($data[GuiUtils::MODE_START_REQUIRED_ITEMS])) ||
			!(isset($data[GuiUtils::MODE_FINISHED_MESSAGE])) ||
			!(isset($data[GuiUtils::MODE_FINISHING_MESSAGE])) ||
			!(isset($data[GuiUtils::MODE_QUEST_DESCRIPTION])) ||
			!(isset($data[GuiUtils::MODE_QUEST_NAME])) ||
			!(isset($data[GuiUtils::MODE_STARTED_MESSAGE])) ||
			!(isset($data[GuiUtils::MODE_STARTING_MESSAGE]))
		) {
			$this->result = false;
		} else {
			$this->result = true;
		}
	}

	public function getResult(): bool {
		return $this->result;
	}
}