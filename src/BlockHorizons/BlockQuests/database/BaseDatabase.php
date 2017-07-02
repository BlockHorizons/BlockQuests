<?php

namespace BlockHorizons\BlockQuests\database;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\quests\Quest;
use pocketmine\IPlayer;

abstract class BaseDatabase {

	/** @var BlockQuests */
	protected $plugin;

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
	 * @return bool
	 */
	public abstract function prepare(): bool;

	/**
	 * @return bool
	 */
	public abstract function close(): bool;

	/**
	 * @param IPlayer $player
	 *
	 * @return Quest[]
	 */
	public function getFinishedQuests(IPlayer $player): array {
		$quests = [];
		foreach($this->getPlayerData($player)["finishedQuests"] as $questId) {
			$quests[] = $this->plugin->getQuestStorage()->fetch($questId);
		}
		return $quests;
	}

	/**
	 * @param IPlayer $player
	 *
	 * @return array
	 */
	public abstract function getPlayerData(IPlayer $player): array;

	/**
	 * @param IPlayer $player
	 *
	 * @return Quest[]
	 */
	public function getStartedQuests(IPlayer $player): array {
		$quests = [];
		foreach($this->getPlayerData($player)["startedQuests"] as $questId) {
			if(in_array($questId, $this->getPlayerData($player)["finishedQuests"])) {
				continue;
			}
			$quests[] = $this->plugin->getQuestStorage()->fetch($questId);
		}
		return $quests;
	}
}