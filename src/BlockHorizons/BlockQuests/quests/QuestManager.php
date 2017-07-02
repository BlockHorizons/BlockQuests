<?php

namespace BlockHorizons\BlockQuests\quests;


use BlockHorizons\BlockQuests\BlockQuests;

class QuestManager {

	/** @var BlockQuests */
	private $plugin;

	public function __construct(BlockQuests $plugin) {
		$this->plugin = $plugin;
	}

	/**
	 * @return BlockQuests
	 */
	public function getPlugin(): BlockQuests {
		return $this->plugin;
	}

	/**
	 * @return Quest[]
	 */
	public function getQuestList(): array {
		$quests = [];
		foreach(scandir($this->plugin->getDataFolder() . "quests/") as $quest) {
			$path = $this->plugin->getDataFolder() . "quests/" . $quest;
			if($quest === "." || $quest === "..") {
				continue;
			}
			$questId = explode(".", $quest)[0];
			if(!is_file($path) || !is_numeric($questId)) {
				continue;
			}
			$data = yaml_parse_file($path);
			if((new QuestValidator($data))->getResult() === false) {
				$this->plugin->getLogger()->debug("Invalid quest content file \'" . $quest . "\' found. Skipping...");
				continue;
			}
			$quests[] = $this->getQuestById((int) $questId);
		}
		return $quests;
	}

	/**
	 * @param int $id
	 *
	 * @return Quest
	 */
	public function getQuestById(int $id): Quest {
		return $this->plugin->getQuestStorage()->fetch($id);
	}
}