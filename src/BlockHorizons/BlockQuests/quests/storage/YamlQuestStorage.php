<?php

namespace BlockHorizons\BlockQuests\quests\storage;

use BlockHorizons\BlockQuests\quests\Quest;

class YamlQuestStorage extends QuestStorage {

	/**
	 * @param Quest $quest
	 *
	 * @return bool indicating whether quest was overwritten or not.
	 */
	public function store(Quest $quest): bool {
		$return = false;
		if($this->exists($quest->getId())) {
			$return = true;
		}
		$folder = $this->getPlugin()->getDataFolder();
		yaml_emit_file($folder . "quests/" . (string) $quest->getId() . ".yml", $quest->parse());
		return $return;
	}

	/**
	 * @param int $questId
	 *
	 * @return bool
	 */
	public function exists(int $questId): bool {
		if(file_exists($this->getPlugin()->getDataFolder() . "quests/" . (string) $questId . ".yml")) {
			return true;
		}
		return false;
	}

	/**
	 * @param int $questId
	 *
	 * @return Quest
	 */
	public function fetch(int $questId): Quest {
		if(!$this->exists($questId)) {
			return new Quest($questId);
		}
		$folder = $this->getPlugin()->getDataFolder();
		$data = yaml_parse_file($folder . "quests/" . (string) $questId . ".yml");
		return new Quest($questId, $data);
	}

	/**
	 * @param int $questId
	 *
	 * @return bool
	 */
	public function delete(int $questId): bool {
		if(!$this->exists($questId)) {
			return false;
		}
		unlink($this->getPlugin()->getDataFolder() . "quests/" . (string) $questId . ".yml");
		return true;
	}
}