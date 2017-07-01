<?php

namespace BlockHorizons\BlockQuests\quests\storage;

use BlockHorizons\BlockQuests\quests\Quest;
use pocketmine\Server;

class YamlQuestStorage {

	/**
	 * @param Quest $quest
	 */
	public static function store(Quest $quest) {
		$folder = Server::getInstance()->getPluginManager()->getPlugin("BlockQuests")->getDataFolder();
		yaml_emit_file($folder . "quests/" . $quest->getId(), $quest->getDataArray());
	}

	/**
	 * @param int $questId
	 *
	 * @return Quest
	 */
	public static function fetch(int $questId): Quest {
		$folder = Server::getInstance()->getPluginManager()->getPlugin("BlockQuests")->getDataFolder();
		$data = yaml_parse_file($folder . "quests/" . $questId);
		return new Quest($questId, $data);
	}
}