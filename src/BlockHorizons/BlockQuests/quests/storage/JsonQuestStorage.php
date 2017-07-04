<?php

namespace BlockHorizons\BlockQuests\quests\storage;

use BlockHorizons\BlockQuests\quests\Quest;

class JsonQuestStorage extends QuestStorage {

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
		file_put_contents($folder . "quests/" . (string) $quest->getId() . ".json", json_encode($quest->parse()));
		return $return;
	}

	/**
	 * @param int $questId
	 *
	 * @return bool
	 */
	public function exists(int $questId): bool {
		if(file_exists($this->getPlugin()->getDataFolder() . "quests/" . (string) $questId . ".json")) {
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
		$data = json_decode(file_get_contents($folder . "quests/" . (string) $questId . ".json"), true);
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
		unlink($this->getPlugin()->getDataFolder() . "quests/" . (string) $questId . ".json");
		return true;
	}
}