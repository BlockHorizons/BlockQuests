<?php

namespace BlockHorizons\BlockQuests\quests;

use pocketmine\item\Item;

class Quest {

	/** @var int */
	private $startExperienceLevel = 0;
	/** @var Item[] */
	private $startRequiredItems = [];
	/** @var Item[] */
	private $finishRequiredItems = [];
	/** @var string[] */
	private $rewardCommands = [];

	/** @var string */
	private $startingMessage = "";
	/** @var string */
	private $finishingMessage = "";
	/** @var string */
	private $startedMessage = "";

	/**
	 * Quest constructor.
	 *
	 * @param array $data
	 *
	 * Should contain an array with any data that should be added. Array keys should be the exact same to the class properties.
	 */
	public function __construct(array $data = []) {
		foreach($data as $key => $value) {
			$this->{$key} = $value;
		}
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
	 * @return string[]
	 */
	public function getRewardCommands(): array {
		return $this->rewardCommands;
	}

	/**
	 * @return string
	 */
	public function getStartingMessage(): string {
		return $this->startingMessage;
	}

	/**
	 * @param string $message
	 */
	public function setStartingMessage(string $message) {
		$this->startingMessasge = $message;
	}

	/**
	 * @return string
	 */
	public function getFinishingMessage(): string {
		return $this->finishingMessage;
	}

	/**
	 * @param string $message
	 */
	public function setFinishingMessage(string $message) {
		$this->finishingMessage = $message;
	}

	/**
	 * @return string
	 */
	public function getStartedMessage(): string {
		return $this->startedMessage;
	}

	/**
	 * @param string $message
	 */
	public function setStartedMessage(string $message) {
		$this->startedMessasge = $message;
	}
}