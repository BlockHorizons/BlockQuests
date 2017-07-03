<?php

namespace BlockHorizons\BlockQuests\listeners;

use BlockHorizons\BlockQuests\BlockQuests;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class EventListener implements Listener {

	private $plugin;

	public function __construct(BlockQuests $plugin) {
		$this->plugin = $plugin;
	}

	/**
	 * @return BlockQuests
	 */
	public function getPlugin(): BlockQuests {
		return $this->plugin;
	}

	public function onJoin(PlayerJoinEvent $event) {
		$this->getPlugin()->getPlayerDatabase()->addPlayer($event->getPlayer());
	}
}