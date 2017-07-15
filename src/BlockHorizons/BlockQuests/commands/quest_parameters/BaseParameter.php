<?php

declare(strict_types = 1);

namespace BlockHorizons\BlockQuests\commands\quest_parameters;

use BlockHorizons\BlockQuests\BlockQuests;
use pocketmine\command\CommandSender;

abstract class BaseParameter {

	/** @var CommandSender */
	protected $sender;
	/** @var string[] */
	protected $args = [];
	/** @var BlockQuests */
	protected $plugin;

	public function __construct(BlockQuests $plugin, CommandSender $sender, array $args) {
		$this->sender = $sender;
		$this->args = $args;
		$this->plugin = $plugin;
	}

	/**
	 * @return CommandSender
	 */
	public function getSender(): CommandSender {
		return $this->sender;
	}

	/**
	 * @return BlockQuests
	 */
	public function getPlugin(): BlockQuests {
		return $this->plugin;
	}

	/**
	 * @return bool
	 */
	public abstract function perform(): bool;
}