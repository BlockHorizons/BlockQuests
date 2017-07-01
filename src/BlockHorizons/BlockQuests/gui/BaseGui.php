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

	protected function send() {
		$this->previousContents = $this->player->getInventory()->getContents();
		for($i = 0; $i < $this->player->getInventory()->gethotBarSize(); $i++) {
			$this->player->getInventory()->clear($i);
		}
		foreach($this->defaults["static"] as $slot => $item) {
			$this->player->getInventory()->setItem($slot, $item);
		}
		foreach($this->defaults["dynamic"][0] as $slot => $item) {
			$this->player->getInventory()->setItem($slot, $item);
		}
	}

	/**
	 * @param int $pageNumber
	 *
	 * @return bool
	 */
	public function goToPage(int $pageNumber): bool {
		if($pageNumber < 1 || $pageNumber > count($this->defaults["dynamic"])) {
			return false;
		}
		for($i = 4; $i < 8; $i++) {
			$this->player->getInventory()->clear($i);
		}
		foreach($this->defaults["dynamic"][$pageNumber - 1] as $slot => $item) {
			$this->player->getInventory()->setItem($slot, $item);
		}
		$this->page = $pageNumber;
		return true;
	}

	public function openGui() {
		$this->send();
		$this->player->sendMessage($this->initMessage);
		$this->getPlugin()->getGuiHandler()->setUsingGui($this->player, true, $this);
	}

	public function closeGui() {
		$this->player->getInventory()->setContents($this->previousContents);
		$this->getPlugin()->getGuiHandler()->setUsingGui($this->player, false, $this);
	}
}