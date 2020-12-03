<?php

namespace TheBlast\SWGUISOLO;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	public function onEnable(){
		$this->getLogger()->info("Sw Join Gui Enabled made by TheBlast");
		if(!InvMenuHandler::isRegistered()){
			InvMenuHandler::register($this);
		}
		$command = new PluginCommand("swsolo", $this);
		$command->setDescription("SwGui command");
		$this->getServer()->getCommandMap()->register("sw", $command);
	}

	public function onDisable(){
		$this->getLogger()->info("Sw Join Gui disabled made by TheBlast");
	}

	public function onCommand(CommandSender $player, Command $cmd, string $label, array $args) : bool{
		switch($cmd->getName()){
			case "swsolo":
				if(!$player instanceof Player){
					$player->sendMessage("Youve been transfered");
					return true;
				}
				$this->swsolo($player);
				break;
		}
		return true;
	}

	public function swsolo(Player $player){
		$menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
		$menu->readOnly();
		$menu->setListener(\Closure::fromCallable([$this, "GUIListener"]));
		$menu->setName("Skywars Games");
		$menu->send($player);
		$inv = $menu->getInventory();
        $grass = Item::get(Item::GRASS)->setCustomName(" SkyWars Solo");
        $feather = Item::get(Item::FEATHER)->setCustomName(" SkyWars Duos");
		$stone = Item::get(Item::STONE)->setCustomName("SkyWars Random");
        $dirt = Item::get(Item::DIRT)->setCustomName(" SkyWars Trios");
		$diamond_sword = Item::get(Item::DIAMOND_SWORD)->setCustomName("SkyWars 1v1 & 2v2");
		$inv->setItem(9, $grass);
		$inv->setItem(11, $feather);
        $inv->setItem(13, $stone);
        $inv->setItem(15, $dirt);
        $inv->setItem(17, $diamond_sword);
	}

	public function GUIListener(InvMenuTransaction $action) : InvMenuTransactionResult{
		$itemClicked = $action->getOut();
		$player = $action->getPlayer();
		if($itemClicked->getId() == 288){
			$action->getAction()->getInventory()->onClose($player);
			$player->sendMessage("Skywars");
			\pocketmine\Server::getInstance()->dispatchCommand($player, "swduo");
			return $action->discard();
		}
		if($itemClicked->getId() == 2){
			$action->getAction()->getInventory()->onClose($player);
			$player->sendMessage("Skywars");
			\pocketmine\Server::getInstance()->dispatchCommand($player, "swsolo");
			return $action->discard();
		}
        if($itemClicked->getId() == 1){
			$action->getAction()->getInventory()->onClose($player);
			$player->sendMessage("Skywars");
			\pocketmine\Server::getInstance()->dispatchCommand($player, "sw random");
			return $action->discard();
		}
        if($itemClicked->getId() == 3){
			$action->getAction()->getInventory()->onClose($player);
			$player->sendMessage("Skywars");
			\pocketmine\Server::getInstance()->dispatchCommand($player, "swtrios");
			return $action->discard();
		}
        if($itemClicked->getId() == 276){
			$action->getAction()->getInventory()->onClose($player);
			$player->sendMessage("Skywars");
			\pocketmine\Server::getInstance()->dispatchCommand($player, "swvs");
			return $action->discard();
		}
		return $action->discard();
	}
}
