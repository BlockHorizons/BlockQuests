<?php

namespace BlockHorizons\BlockQuests\gui;

use BlockHorizons\BlockQuests\BlockQuests;
use pocketmine\item\Item;
use pocketmine\Player;

abstract class BaseGui {

	/** @var BlockQuests */
	protected $plugin;

	/** @var string */
	protected $initMessage = "";
	/** @var string */
	protected $finishMessage = "";

	/** @var Player */
	protected $player;
	/** @var Item[] */
	protected $previousContents = [];
	/** @var Item[] */
	protected $defaults = [];
	/** @var int */
	protected $page = 1;

	public function __construct(BlockQuests $plugin, Player $player) {
		$this->plugin = $plugin;
		$this->player = $player;
	}

	/**
	 * @return BlockQuests
	 */
	public function getPlugin(): BlockQuests {
		return $this->plugin;
	}

	/**
	 * @return string
	 */
	public function getInitializeMessage(): string {
		return $this->initMessage;
	}

	/**
	 * @return string
	 */
	public function getFinalizeMessage(): string {
		return $this->finishMessage;
	}

	/**
	 * @return Player
	 */
	public function getPlayer(): Player {
		return $this->player;
	}

	/**
	 * @return int
	 */
	public function getPage(): int {
		return $this->page;
	}

	/**
	 * @param bool $cancelled
	 */
	public abstract function closeGui(bool $cancelled = true);

	public abstract function openGui();

	/**
	 * @param int $pageNumber
	 *
	 * @return bool
	 */
	public abstract function goToPage(int $pageNumber): bool;
}