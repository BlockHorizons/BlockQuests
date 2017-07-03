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

		$this->prepare();
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
	 * @param string $string
	 *
	 * @return string
	 */
	public abstract function escape(string $string): string;

	/**
	 * @param IPlayer $player
	 *
	 * @return Quest[]
	 */
	public function getFinishedQuests(IPlayer $player): array {
		$quests = [];
		foreach($this->getPlayerData($player)["FinishedQuests"] as $questId) {
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
		foreach($this->getPlayerData($player)["StartedQuests"] as $questId) {
			if(in_array($questId, $this->getPlayerData($player)["FinishedQuests"])) {
				continue;
			}
			$quests[] = $this->plugin->getQuestStorage()->fetch($questId);
		}
		return $quests;
	}

	/**
	 * @param IPlayer $player
	 * @param int     $questId
	 *
	 * @return bool
	 */
	public function startQuest(IPlayer $player, int $questId): bool {
		$startedQuests = $this->getStartedQuests($player);
		$startedQuests[] = $questId;
		return $this->updateStartedQuests($player, serialize($startedQuests));
	}

	/**
	 * @param IPlayer $player
	 * @param int     $questId
	 *
	 * @return bool
	 */
	public function finishQuest(IPlayer $player, int $questId): bool {
		$finishedQuests = $this->getFinishedQuests($player);
		$finishedQuests[] = $questId;
		return $this->updateFinishedQuests($player, serialize($finishedQuests));
	}

	/**
	 * @param IPlayer $player
	 * @param string  $serializedData
	 *
	 * @return bool
	 */
	public abstract function updateStartedQuests(IPlayer $player, string $serializedData): bool;

	/**
	 * @param IPlayer $player
	 * @param string  $serializedData
	 *
	 * @return bool
	 */
	public abstract function updateFinishedQuests(IPlayer $player, string $serializedData): bool;

	/**
	 * @param IPlayer $player
	 *
	 * @return bool
	 */
	public abstract function playerExists(IPlayer $player): bool;

	/**
	 * @param IPlayer $player
	 *
	 * @return bool
	 */
	public abstract function addPlayer(IPlayer $player): bool;

	/**
	 * @param IPlayer $player
	 *
	 * @return bool
	 */
	public abstract function clearData(IPlayer $player): bool;

	/**
	 * @param IPlayer $player
	 * @param int     $questId
	 *
	 * @return bool
	 */
	public abstract function hasQuestStarted(IPlayer $player, int $questId): bool;

	/**
	 * @param IPlayer $player
	 * @param int     $questId
	 *
	 * @return bool
	 */
	public abstract function hasQuestFinished(IPlayer $player, int $questId): bool;

	public function __destruct() {
		$this->close();
	}
}