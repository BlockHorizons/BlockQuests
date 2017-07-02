<?php

namespace BlockHorizons\BlockQuests\gui;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\quests\Quest;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

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

	/** @var Quest */
	protected $quest;
	/** @var int */
	private $questId;

	public function __construct(BlockQuests $plugin, Player $player, int $questId) {
		$this->questId = $questId;
		$this->plugin = $plugin;
		$this->player = $player;
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
	 * @param int $pageNumber
	 *
	 * @return bool
	 */
	public function goToPage(int $pageNumber): bool {
		if($pageNumber < 1 || $pageNumber > count($this->defaults["dynamic"])) {
			return false;
		}
		$this->getPlugin()->getGuiHandler()->allowInventoryChange = true;
		foreach($this->defaults["dynamic"][$pageNumber - 1] as $slot => $item) {
			$this->player->getInventory()->setItem($slot, $item);
		}
		$this->getPlugin()->getGuiHandler()->allowInventoryChange = false;
		$this->page = $pageNumber;
		$this->player->sendTip(TextFormat::GREEN . TextFormat::BOLD . "[" . $pageNumber . "/" . count($this->defaults["dynamic"]) . "]");
		return true;
	}

	/**
	 * @return BlockQuests
	 */
	public function getPlugin(): BlockQuests {
		return $this->plugin;
	}

	public function openGui() {
		$this->sendInitial();
		$this->player->sendTip($this->initMessage);
		$this->getPlugin()->getGuiHandler()->setUsingGui($this->player, true, $this);
	}

	protected function sendInitial() {
		$this->previousContents = $this->player->getInventory()->getContents();
		$this->player->getInventory()->resetHotbar();

		foreach($this->defaults["static"] as $slot => $item) {
			$this->player->getInventory()->setItem($slot, $item);
		}
		foreach($this->defaults["dynamic"][0] as $slot => $item) {
			$this->player->getInventory()->setItem($slot, $item);
		}
	}

	/**
	 * @param bool $cancelled
	 */
	public function closeGui(bool $cancelled = true) {
		$this->player->getInventory()->setContents($this->previousContents);

		if(!$cancelled && isset($this->quest)) {
			$this->quest->store();
		}
		$this->player->sendTip($this->finishMessage);
	}

	/**
	 * @param Item  $item
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function callBackGuiItem(Item $item, $value): bool {
		if(!isset($this->quest)) {
			$this->quest = new Quest($this->questId);
		}
		if($item->getNamedTag()->bqGuiInputMode->getValue() === "") {
			return false;
		}
		$this->quest->{$item->getNamedTag()->bqGuiInputMode->getValue()} = $value;
		return true;
	}
}