<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 22.01.17
 * Time: 18:34
 */

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        Fixtures::load(__DIR__.'/Fixtures.yml',$manager,
            [
                'providers' => [$this]
            ]);
    }

    public function passkey(){

        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }


}