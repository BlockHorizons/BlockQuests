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
use pocketmine\item\Item;
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
			$output = null;
			$gui = $this->getPlugin()->getGuiHandler()->getGui($event->getPlayer());
			$item = $event->getPlayer()->getInventory()->getItemInHand();
			$input = $event->getMessage();
			switch($item->getNamedTag()->bqGuiInputType->getValue()) {
				case GuiUtils::TYPE_ENTER_ITEMS:
					$nameList = [];
					$inputItems = explode(",", $input);
					foreach($inputItems as &$inputItem) {
						if(is_numeric($inputItem)) {
							$inputItem = Item::get((int) $inputItem);
						} else {
							$inputItem = Item::fromString($inputItem);
						}
						$nameList[] = $inputItem->getName();
					}
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Input Items: " . TextFormat::AQUA . implode(" ", $nameList));
					/** @var Item $inputItem */
					foreach($inputItems as $inputItem) {
						$output[] = (string) $inputItem->getId() . ":" . (string) $inputItem->getDamage() . ":" . (string) $inputItem->getCount();
					}
					break;
				case GuiUtils::TYPE_ENTER_INT:
					if(!is_numeric($input)) {
						$output = 0;
					} else {
						$output = (int) $input;
					}
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Input Integer: " . TextFormat::AQUA . (string) $output);
					break;
				case GuiUtils::TYPE_ENTER_TEXT:
					$output = (string) $input;
					$event->getPlayer()->sendMessage(TextFormat::GREEN . "Input Text: " . TextFormat::AQUA . $output);
					break;
			}
			$gui->callBackGuiItem($item, $output);
			$event->setCancelled();
		}
	}

	/**
	 * @param PlayerItemHeldEvent $event
	 */
	public function onItemHeld(PlayerItemHeldEvent $event) {
		if($this->getPlugin()->getGuiHandler()->isUsingGui($event->getPlayer())) {
			if(!isset($event->getItem()->getNamedTag()->bqGuiInputType)) {
				return;
			}
			switch($event->getItem()->getNamedTag()->bqGuiInputType->getValue()) {
				default:
				case GuiUtils::TYPE_CANCEL:
					$message = TextFormat::GREEN . "Tap the ground to cancel.";
					break;
				case GuiUtils::TYPE_FINALIZE:
					$message = TextFormat::GREEN . "Tap the ground to finalize.";
					break;
				case GuiUtils::TYPE_NEXT:
					$message = TextFormat::GREEN . "Tap the ground to go to the next page.";
					break;
				case GuiUtils::TYPE_PREVIOUS:
					$message = TextFormat::GREEN . "Tap the ground to go to the previous page.";
					break;
				case GuiUtils::TYPE_ENTER_ITEMS:
					$message = TextFormat::GREEN . "Enter an item in the chat. Can be multiple by separating them with commas.";
					break;
				case GuiUtils::TYPE_ENTER_INT:
					$message = TextFormat::GREEN . "Enter a numeric value in the chat.";
					break;
				case GuiUtils::TYPE_ENTER_TEXT:
					$message = TextFormat::GREEN . "Enter a text in the chat.";
					break;
			}
			$event->getPlayer()->sendTip($message);
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
			switch($event->getItem()->getNamedTag()->bqGuiInputType->getValue()) {
				case GuiUtils::TYPE_CANCEL:
					$this->getPlugin()->getGuiHandler()->setUsingGui($event->getPlayer(), false, $gui, true);
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