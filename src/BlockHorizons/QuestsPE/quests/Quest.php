<?php

namespace BlockHorizons\QuestsPE\quests;

use pocketmine\item\Item;

class Quest {

	/** @var int */
	private $startExperienceLevel = 0;
	/** @var array */
	private $startRequiredItems = [];
	/** @var array */
	private $finishRequiredItems = [];
	/** @var array */
	private $rewardCommands = [];

	/**
	 * @param int      $startExperienceLevel
	 * @param Item[]   $startRequiredItems
	 * @param Item[]   $finishRequiredItems
	 * @param string[] $rewardCommands
	 */
	public function __construct(int $startExperienceLevel = 0, array $startRequiredItems = [], array $finishRequiredItems = [], array $rewardCommands = []) {
		$this->startExperienceLevel = $startExperienceLevel;
		$this->startRequiredItems = $startRequiredItems;
		$this->finishRequiredItems = $finishRequiredItems;
		$this->rewardCommands = $rewardCommands;
	}

	/**
	 * @param int $level
	 */
	public function setStartExperienceLevel(int $level) {
		$this->startExperienceLevel = $level;
	}

	/**
	 * @return int
	 */
	public function getStartExperienceLevel(): int {
		return $this->startExperienceLevel;
	}

	/**
	 * @param Item[] $items
	 */
	public function setStartRequiredItems(array $items) {
		$this->startRequiredItems = $items;
	}

	/**
	 * @return Item[]
	 */
	public function getStartRequiredItems(): array {
		return $this->startRequiredItems;
	}

	/**
	 * @param Item[] $items
	 */
	public function setFinishRequiredItems(array $items) {
		$this->finishRequiredItems = $items;
	}

	/**
	 * @return Item[]
	 */
	public function getFinishRequiredItems(): array {
		return $this->finishRequiredItems;
	}

	/**
	 * @param string[] $commands
	 */
	public function setRewardCommands(array $commands) {
		$this->rewardCommands = $commands;
	}

	/**
	 * @return array
	 */
	public function getRewardCommands(): array {
		return $this->rewardCommands;
	}
}