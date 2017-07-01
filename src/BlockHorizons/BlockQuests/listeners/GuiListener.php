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
			switch($event->getItem()->getNamedTag()->bqGuiType->getValue()) {
				case GuiUtils::TYPE_CANCEL:
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Tap the ground to cancel.");
					break;
				case GuiUtils::TYPE_FINALIZE:
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Tap the ground to finalize.");
					break;
				case GuiUtils::TYPE_NEXT:
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Tap the ground to go to the next page.");
					break;
				case GuiUtils::TYPE_PREVIOUS:
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Tap the ground to go to the previous page.");
					break;
				case GuiUtils::TYPE_ENTER_ITEMS:
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Enter an item in the chat. Can be multiple by separating them with commas.");
					break;
				case GuiUtils::TYPE_ENTER_INT:
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Enter a numeric value in the chat.");
					break;
				case GuiUtils::TYPE_ENTER_TEXT:
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
			$this->getPlugin()->getGuiHandler()->setUsingGui($event->getPlayer(), false, $this->getPlugin()->getGuiHandler()->getGui($event->getPlayer()));
		}
	}

	/**
	 * @param PlayerInteractEvent $event
	 */
	public function onInteract(PlayerInteractEvent $event) {
		if($this->getPlugin()->getGuiHandler()->isUsingGui($event->getPlayer())) {
			$gui = $this->getPlugin()->getGuiHandler()->getGui($event->getPlayer());
			switch($event->getItem()->getNamedTag()->bqGuiType->getValue()) {
				case GuiUtils::TYPE_CANCEL:
					$this->getPlugin()->getGuiHandler()->setUsingGui($event->getPlayer(), false, $gui);
					break;
				case GuiUtils::TYPE_FINALIZE:
					$this->getPlugin()->getGuiHandler()->setUsingGui($event->getPlayer(), false, $gui, false);
					break;
				case GuiUtils::TYPE_NEXT:
					$gui->goToPage($gui->getPage() + 1);
					break;
				case GuiUtils::TYPE_PREVIOUS:
					$gui->goToPage($gui->getPage() - 1);
					break;
			}
		}
	}
}