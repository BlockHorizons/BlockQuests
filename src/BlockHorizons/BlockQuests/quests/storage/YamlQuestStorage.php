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
		file_put_contents($folder . "quests/" . $quest->getId(), "");
		yaml_emit_file($folder . "quests/" . $quest->getId(), $quest->parse());
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