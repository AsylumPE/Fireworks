<?php

declare(strict_types = 1);

namespace BlockHorizons\Fireworks;

use BlockHorizons\Fireworks\item\Fireworks;
use BlockHorizons\Fireworks\entity\FireworksRocket;

use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

	public function onEnable(): void {
		ItemFactory::registerItem(new Fireworks());
		Item::initCreativeItems(); //will load firework rockets from pocketmine's resources folder
		if(!Entity::registerEntity(FireworksRocket::class, false, ["FireworksRocket"])) {
			$this->getLogger()->error("Failed to register FireworksRocket entity with savename 'FireworksRocket'");
		}
	}

	public function onJoin(PlayerJoinEvent $event) : void{
		$fw = ItemFactory::get(Item::FIREWORKS);
$fw->addExplosion(Fireworks::TYPE_CREEPER_HEAD, Fireworks::COLOR_GREEN, "", false, false);
$fw->setFlightDuration(2);

// Use whatever level you'd like here. Must be loaded
$level = Server::getInstance()->getDefaultLevel();
// Choose some coordinates
$vector3 = $level->getSpawnLocation()->add(0.5, 1, 0.5);
// Create the NBT data
$nbt = FireworksRocket::createBaseNBT($vector3, new Vector3(0.001, 0.05, 0.001), lcg_value() * 360, 90);
// Construct and spawn
$entity = FireworksRocket::createEntity("FireworksRocket", $level, $nbt, $fw);
if ($entity instanceof FireworksRocket) {
    $entity->spawnToAll();
}

}

}
