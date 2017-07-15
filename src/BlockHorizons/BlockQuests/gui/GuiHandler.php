<?php

declare(strict_types = 1);

namespace BlockHorizons\BlockQuests\gui;

use BlockHorizons\BlockQuests\BlockQuests;
use pocketmine\Player;

class GuiHandler {

	/** @var bool */
	public $allowInventoryChange = false;
	private $plugin;
	private $usingGui = [];
	/** @var BaseGui */
	private $gui = [];

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
	 * @param Player  $player
	 * @param bool    $value
	 * @param BaseGui $gui
	 * @param bool    $finishCancelled
	 */
	public function setUsingGui(Player $player, bool $value = true, BaseGui $gui, bool $finishCancelled = true) {
		$this->usingGui[$player->getId()] = $value;

		if($value === true) {
			$this->gui[] = $gui;
		} else {
			$gui = $this->gui[$this->getGuiIdByPlayer($player)];
			if($gui instanceof BaseGui) {
				$gui->closeGui($finishCancelled);
			}
			unset($this->gui[$this->getGuiIdByPlayer($player)]);
		}
	}

	/**
	 * @param Player $player
	 *
	 * @return int
	 */
	public function getGuiIdByPlayer(Player $player) {
		/**
		 * @var int     $id
		 * @var BaseGui $gui
		 */
		foreach($this->gui as $id => $gui) {
			if($gui->getPlayer()->getName() === $player->getName()) {
				return $id;
			}
		}
		return null;
	}

	/**
	 * @param Player $player
	 *
	 * @return bool
	 */
	public function isUsingGui(Player $player): bool {
		return isset($this->usingGui[$player->getId()]) && $this->usingGui[$player->getId()] === true;
	}

	/**
	 * @param Player $player
	 *
	 * @return BaseGui|null
	 */
	public function getGui(Player $player) {
		return $this->getGuiById($this->getGuiIdByPlayer($player));
	}

	/**
	 * @param int $id
	 *
	 * @return BaseGui|null
	 */
	public function getGuiById(int $id) {
		return isset($this->gui[$id]) ? $this->gui[$id] : null;
	}
}