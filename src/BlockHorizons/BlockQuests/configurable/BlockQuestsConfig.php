<?php

declare(strict_types = 1);

namespace BlockHorizons\BlockQuests\configurable;

use BlockHorizons\BlockQuests\BlockQuests;

class BlockQuestsConfig {

	/** @var BlockQuests */
	private $plugin;
	/** @var array */
	private $settings;

	public function __construct(BlockQuests $plugin) {
		$this->plugin = $plugin;
		$plugin->saveDefaultConfig();
		$this->collectPreferences();
	}

	public function collectPreferences() {
		$data = yaml_parse_file($this->getPlugin()->getDataFolder() . "config.yml");
		$this->settings = $data;
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
	public function getQuestDataStorage(): string {
		return $this->settings["Quest-Saving-Data-Provider"] ?? "yaml";
	}

	/**
	 * @return string
	 */
	public function getPlayerDataStorage(): string {
		return $this->settings["Player-Quests-Database"] ?? "sqlite";
	}

	/**
	 * @return string
	 */
	public function getQuestStartingFormat(): string {
		return $this->settings["Quest-Starting-Format"] ?? "{STARTING_MESSAGE}\nQuest Started: {QUEST_NAME}\n{QUEST_DESCRIPTION}";
	}
}