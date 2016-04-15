<?php
namespace Beleche\OpMonitor;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\plugin;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\Cancellable;


class OpMonitorMain extends PluginBase implements Listener {
	
	public $config;
	public $opdrop;
	public $opchest;
	public $message_e;
	public $messagedrop;
	public $messagechest;
	public function onEnable() {
		
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->logOnConsole("Inicializado com sucesso!");
		$this->saveDefaultConfig();
		
		$this->opdrop = true;
		$this->opchest = true;
		$this->message_e = true;
		$this->messagedrop = "You can not drop items .";
		$this->messagechest = "You can not interact on the chest in creative mode.";
		
		$this->opdrop = $this->getConfig()->get("opdrop");
		$this->opchest = $this->getConfig()->get("opchest");
		$this->message_e = $this->getConfig()->get("message");
		$this->messagedrop = $this->getConfig()->get("messagedrop");
		$this->messagechest = $this->getConfig()->get("messagechest");
    }

	public function logOnConsole($message){
		$logger = Server::getInstance()->getLogger();
		$logger->info("§9[OpMonitor]§a " . $message);
	}
	
	public function onCommand(CommandSender $sender,Command $command,$label,array $args){
        if($sender instanceof Player){
			if($sender->getPlayer()->isOp()){
				if($command == "opm"){
					if($args[0] == "reload"){
						$this->config = new Config($this->getDataFolder() . "config.yml");
						$this->opdrop = $this->config->get("opdrop");
						$this->opchest = $this->config->get("opchest");
						$this->message_e = $this->config->get("message");
						$this->messagedrop = $this->config->get("messagedrop");
						$this->messagechest = $this->config->get("messagechest");
						$sender->getPlayer()->sendMessage("§6OpDrop:§a " . $this->opdrop);
						$sender->getPlayer()->sendMessage("§6OpChest:§a " . $this->opchest);
						$sender->getPlayer()->sendMessage("§6Show Message:§a " . $this->message_e);
					}
				}
			}else{
				$sender->getPlayer()->sendMessage("§6You can not use this command!");
			}
		}
	}
	
	public function InteractEvent(PlayerInteractEvent $e){
		$item = $e->getItem();
		$item_id = $item->getId();
		$block = $e->getBlock()->getId();
		$item_damage = $item->getDamage();
		
		if($this->opchest){
			
		}else{
			switch($block){
				case 54;
					if($e->getPlayer()->isOp()){
						if($e->getPlayer()->isCreative()){
							
							$e->setCancelled();
							
						}
						if($this->message_e){
							$e->getPlayer()->sendMessage($this->messagechest);
						}
					}else{
						
					}
					break;
			}
			
		}
		
	}
	
	public function DropEvent(PlayerDropItemEvent $e){
		if($this->opdrop){
			
		}else{
			if($e->getPlayer()->isOp()){
				$e->setCancelled();
				
			}
			if($this->message_e){
				$e->getPlayer()->sendMessage($this->messagechest);
			}
		}
	}
}