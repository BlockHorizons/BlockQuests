<?php

namespace BlockHorizons\BlockQuests\quests;

use BlockHorizons\BlockQuests\quests\storage\YamlQuestStorage;
use pocketmine\item\Item;
use pocketmine\Server;

class Quest {

	private $id;
	/** @var string */
	public $questName = "";
	/** @var string */
	public $questDescription = "";
	/** @var int */
	public $startExperienceLevel = 0;
	/** @var Item[] */
	public $startRequiredItems = [];
	/** @var Item[] */
	public $finishRequiredItems = [];
	/** @var string[] */
	public $rewardCommands = [];

	/** @var string */
	public $startingMessage = "";
	/** @var string */
	public $finishingMessage = "";
	/** @var string */
	public $startedMessage = "";
	/** @var string */
	public $finishedMessage = "";

	/**
	 * Quest constructor.
	 *
	 * @param int   $id
	 * @param array $data
	 *
	 * Should contain an array with any data that should be added. Array keys should be the exact same to the class properties.
	 */
	public function __construct(int $id, array $data = []) {
		$this->id = $id;
		foreach($data as $key => $value) {
			$this->{$key} = $value;
		}
	}

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * @param string $name
	 */
	public function setQuestName(string $name) {
		$this->questName = $name;
	}

	/**
	 * @return string
	 */
	public function getQuestName(): string {
		return $this->questName;
	}

	/**
	 * @param string $description
	 */
	public function setQuestDescription(string $description) {
		$this->questDescription = $description;
	}

	/**
	 * @return string
	 */
	public function getQuestDescription(): string {
		return $this->questDescription;
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
	 * @param string[] $items
	 */
	public function setStartRequiredItems(array $items) {
		$this->startRequiredItems = $items;
	}

	/**
	 * @return Item[]
	 */
	public function getStartRequiredItems(): array {
		$items = [];
		foreach($this->startRequiredItems as $item) {
			$items[] = Item::fromString($item);
		}
		return $items;
	}

	/**
	 * @param string[] $items
	 */
	public function setFinishRequiredItems(array $items) {
		$this->finishRequiredItems = $items;
	}

	/**
	 * @return Item[]
	 */
	public function getFinishRequiredItems(): array {
		$items = [];
		foreach($this->finishRequiredItems as $item) {
			$items[] = Item::fromString($item);
		}
		return $items;
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

	/**
	 * @return string
	 */
	public function getFinishedMessage(): string {
		return $this->finishedMessage;
	}

	/**
	 * @param string $message
	 */
	public function setFinishedMessage(string $message) {
		$this->finishedMessage = $message;
	}

	/**
	 * @return bool
	 */
	public function store(): bool {
		YamlQuestStorage::store($this);
		return true;
	}

	/**
	 * @return array
	 */
	public function getDataArray(): array {
		$data = [];
		foreach($this as $key => $value) {
			$data[$key] = $value;
		}
		return $data;
	}
}