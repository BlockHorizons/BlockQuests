<?php

namespace BlockHorizons\BlockQuests\database;


use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\quests\Quest;
use pocketmine\IPlayer;

class SQLiteQuestDatabase extends BaseDatabase {

	/** @var \SQLite3 */
	private $database;

	public function __construct(BlockQuests $plugin) {
		parent::__construct($plugin);
	}

	/**
	 * @return bool
	 */
	public function prepare(): bool {
		if(!file_exists($path = $this->getPlugin()->getDataFolder() . "quest_stats.sqlite3")) {
			file_put_contents($path, "");
		}
		$this->database = new \SQLite3($path);
		$query = "CREATE TABLE IF NOT EXISTS QuestStats(
			Player VARCHAR(16) PRIMARY KEY,
			StartedQuests VARCHAR,
			FinishedQuests VARCHAR
		)";
		return $this->database->exec($query);
	}

	/**
	 * @return bool
	 */
	public function close(): bool {
		if($this->database instanceof \SQLite3) {
			$this->database->close();
			return true;
		}
		return false;
	}

	/**
	 * @param IPlayer $player
	 *
	 * @return array
	 */
	public function getPlayerData(IPlayer $player): array {
		$player = strtolower($player->getName());
		$query = "SELECT * FROM QuestStats WHERE Player = '" . $this->escape($player) . "'";

		$results = $this->database->query($query)->fetchArray(SQLITE3_ASSOC);
		foreach($results as $key => $result) {
			if($key === "Player") {
				continue;
			}
			if(empty($result) || $result === 0) {
				continue;
			}
			$results[$key] = unserialize($result);
		}
		return $results;
	}

	/**
	 * @param IPlayer $player
	 *
	 * @return bool
	 */
	public function playerExists(IPlayer $player): bool {
		$player = strtolower($player->getName());
		$query = "SELECT * FROM QuestStats WHERE Player = '" . $this->escape($player) . "'";

		$result = $this->database->query($query)->fetchArray(SQLITE3_ASSOC);
		if(empty($result)) {
			return false;
		}
		return true;
	}

	/**
	 * @param IPlayer $player
	 *
	 * @return bool
	 */
	public function addPlayer(IPlayer $player): bool {
		if($this->playerExists($player)) {
			return false;
		}
		$player = strtolower($player->getName());
		$query = "INSERT INTO QuestStats(Player, StartedQuests, FinishedQuests) VALUES ('" . $this->escape($player) . "', 0, 0)";
		return $this->database->exec($query);
	}

	/**
	 * @param IPlayer $player
	 * @param string  $serializedData
	 *
	 * @return bool
	 */
	public function updateStartedQuests(IPlayer $player, string $serializedData): bool {
		if(!$this->playerExists($player)) {
			return false;
		}
		$player = strtolower($player->getName());
		$query = "UPDATE QuestStats SET StartedQuests = '" . $this->escape($serializedData) . "' WHERE Player = '" . $this->escape($player) . "'";
		return $this->database->exec($query);
	}

	/**
	 * @param IPlayer $player
	 * @param string  $serializedData
	 *
	 * @return bool
	 */
	public function updateFinishedQuests(IPlayer $player, string $serializedData): bool {
		if(!$this->playerExists($player)) {
			return false;
		}
		$player = strtolower($player->getName());
		$query = "UPDATE QuestStats SET FinishedQuests = '" . $this->escape($serializedData) . "' WHERE Player = '" . $this->escape($player) . "'";
		return $this->database->exec($query);
	}

	/**
	 * @param IPlayer $player
	 *
	 * @return bool
	 */
	public function clearData(IPlayer $player): bool {
		if(!$this->playerExists($player)) {
			return false;
		}
		$player = strtolower($player->getName());
		$query = "DELETE FROM QuestStats WHERE Player = '" . $this->escape($player) . "'";
		return $this->database->exec($query);
	}

	/**
	 * @param string $string
	 *
	 * @return string
	 */
	public function escape(string $string): string {
		return \SQLite3::escapeString($string);
	}

	/**
	 * @param IPlayer $player
	 * @param int     $questId
	 *
	 * @return bool
	 */
	public function hasQuestFinished(IPlayer $player, int $questId): bool {
		if(!$this->playerExists($player)) {
			return false;
		}
		foreach($this->getFinishedQuests($player) as $quest) {
			if($quest->getId() === $questId) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param IPlayer $player
	 * @param int     $questId
	 *
	 * @return bool
	 */
	public function hasQuestStarted(IPlayer $player, int $questId): bool {
		if(!$this->playerExists($player)) {
			return false;
		}
		foreach($this->getStartedQuests($player) as $quest) {
			if($quest->getId() === $questId) {
				return true;
			}
		}
		return false;
	}
}