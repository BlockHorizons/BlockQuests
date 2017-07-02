<?php

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
}