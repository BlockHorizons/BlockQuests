<?php

namespace BlockHorizons\BlockQuests\listeners;

use BlockHorizons\BlockQuests\BlockQuests;
use BlockHorizons\BlockQuests\gui\GuiUtils;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityInventoryChangeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class GuiListener implements Listener {

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

	/**
	 * @param PlayerChatEvent $event
	 */
	public function onChat(PlayerChatEvent $event) {
		if($this->getPlugin()->getGuiHandler()->isUsingGui($event->getPlayer())) {
			// TODO: Handle
			$event->setCancelled();
		}
	}

	/**
	 * @param PlayerItemHeldEvent $event
	 */
	public function onItemHeld(PlayerItemHeldEvent $event) {
		if($this->getPlugin()->getGuiHandler()->isUsingGui($event->getPlayer())) {
			switch($event->getItem()->getNamedTag()->namedtag->bqGuiType) {
				case 0:
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Tap the ground to cancel.");
					break;
				case 10:
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Tap the ground to finalize.");
					break;
				case 1:
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Enter an item in the chat. Can be multiple by separating them with commas.");
					break;
				case 2:
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Enter a numeric value in the chat.");
					break;
				case 3:
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Enter a text in the chat.");
					break;
			}
		}
	}

	/**
	 * @param EntityInventoryChangeEvent $event
	 */
	public function onInventoryChange(EntityInventoryChangeEvent $event) {
		if($event->getEntity() instanceof Player) {
			if($this->getPlugin()->getGuiHandler()->isUsingGui($event->getEntity())) {
				$event->setCancelled();
			}
		}
	}

	/**
	 * @param PlayerQuitEvent $event
	 */
	public function onQuit(PlayerQuitEvent $event) {
		if($this->getPlugin()->getGuiHandler()->isUsingGui($event->getPlayer())) {
			$this->getPlugin()->getGuiHandler()->setUsingGui($event->getPlayer(), false, $this->getPlugin()->getGuiHandler()->getGuiById($this->getPlugin()->getGuiHandler()->getGuiIdByPlayer($event->getPlayer())));
		}
	}

	/**
	 * @param PlayerInteractEvent $event
	 */
	public function onInteract(PlayerInteractEvent $event) {
		if($this->getPlugin()->getGuiHandler()->isUsingGui($event->getPlayer())) {
			if($event->getItem()->getNamedTag()->namedtag->bqGuiType === GuiUtils::TYPE_CANCEL) {
				$this->getPlugin()->getGuiHandler()->setUsingGui($event->getPlayer(), false, $this->getPlugin()->getGuiHandler()->getGuiById($this->getPlugin()->getGuiHandler()->getGuiIdByPlayer($event->getPlayer())));
			} elseif($event->getItem()->getNamedTag()->namedtag->bqGuiType === GuiUtils::TYPE_FINALIZE) {
				$this->getPlugin()->getGuiHandler()->setUsingGui($event->getPlayer(), false, $this->getPlugin()->getGuiHandler()->getGuiById($this->getPlugin()->getGuiHandler()->getGuiIdByPlayer($event->getPlayer())), false);
			}
		}
	}
}