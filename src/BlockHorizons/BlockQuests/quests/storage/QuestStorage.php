<?php

namespace BlockHorizons\BlockQuests\quests\storage;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\quests\Quest;
use pocketmine\block\Block;

abstract class QuestStorage {

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
	 * @param Quest $quest
	 *
	 * @return bool
	 */
	public abstract function store(Quest $quest): bool;

	/**
	 * @param int $questId
	 *
	 * @return Quest
	 */
	public abstract function fetch(int $questId): Quest;

	/**
	 * @param int $questId
	 *
	 * @return bool
	 */
	public abstract function delete(int $questId): bool;

	/**
	 * @param int $questId
	 *
	 * @return bool
	 */
	public abstract function exists(int $questId): bool;
}