<?php

namespace BlockHorizons\BlockQuests;

use BlockHorizons\BlockQuests\commands\BlockQuestsCommand;
use BlockHorizons\BlockQuests\commands\QuestCommand;
use BlockHorizons\BlockQuests\configurable\BlockQuestsConfig;
use BlockHorizons\BlockQuests\database\BaseDatabase;
use BlockHorizons\BlockQuests\database\SQLiteQuestDatabase;
use BlockHorizons\BlockQuests\gui\GuiHandler;
use BlockHorizons\BlockQuests\listeners\EventListener;
use BlockHorizons\BlockQuests\listeners\GuiListener;
use BlockHorizons\BlockQuests\quests\QuestManager;
use BlockHorizons\BlockQuests\quests\storage\JsonQuestStorage;
use BlockHorizons\BlockQuests\quests\storage\QuestStorage;
use BlockHorizons\BlockQuests\quests\storage\YamlQuestStorage;
use pocketmine\plugin\PluginBase;

class BlockQuests extends PluginBase {

	/** @var GuiHandler */
	private $guiHandler;
	/** @var QuestStorage */
	private $questStorage;
	/** @var BlockQuestsConfig */
	private $bqConfig;
	/** @var QuestManager */
	private $questManager;
	/** @var BaseDatabase */
	private $playerStorage;

	public function onEnable() {
		$this->saveDefaultConfig();
		if(!is_dir($this->getDataFolder() . "quests/")) {
			mkdir($this->getDataFolder() . "quests/");
		}
		$this->bqConfig = new BlockQuestsConfig($this);
		$this->registerCommands();
		$this->registerListeners();

		$this->guiHandler = new GuiHandler($this);
		$this->questManager = new QuestManager($this);
		$this->initializeStorage();
		$this->initializeDatabase();
	}

	public function registerCommands() {
		$commands = [
			new QuestCommand($this)
		];
		/** @var BlockQuestsCommand $command */
		foreach($commands as $command) {
			$this->getServer()->getCommandMap()->register($command->getName(), $command);
		}
	}

	public function registerListeners() {
		$listeners = [
			new GuiListener($this),
			new EventListener($this)
		];
		foreach($listeners as $listener) {
			$this->getServer()->getPluginManager()->registerEvents($listener, $this);
		}
	}

	/**
	 * @return QuestStorage
	 */
	public function initializeStorage(): QuestStorage {
		switch($this->getBlockQuestsConfig()->getQuestDataStorage()) {
			default:
			case "yaml":
			case "yml":
				$this->questStorage = new YamlQuestStorage($this);
				break;
			case "json":
				$this->questStorage = new JsonQuestStorage($this);
				break;
		}
		return $this->questStorage;
	}

	/**
	 * @return BaseDatabase
	 */
	public function initializeDatabase(): BaseDatabase {
		switch($this->getBlockQuestsConfig()->getPlayerDataStorage()) {
			default:
			case "sqlite":
			case "sqlite3":
				$this->playerStorage = new SQLiteQuestDatabase($this);
				break;
		}
		return $this->playerStorage;
	}

	/**
	 * @return BaseDatabase
	 */
	public function getPlayerDatabase(): BaseDatabase {
		return $this->playerStorage;
	}

	/**
	 * @return BlockQuestsConfig
	 */
	public function getBlockQuestsConfig(): BlockQuestsConfig {
		return $this->bqConfig;
	}

	/**
	 * @return GuiHandler
	 */
	public function getGuiHandler(): GuiHandler {
		return $this->guiHandler;
	}

	/**
	 * @return QuestStorage
	 */
	public function getQuestStorage(): QuestStorage {
		return $this->questStorage;
	}

	/**
	 * @return QuestManager
	 */
	public function getQuestManager(): QuestManager {
		return $this->questManager;
	}
}