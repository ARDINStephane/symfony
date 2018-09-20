<?php

namespace App\DataFixtures;

use App\Applications\Doctrine\Entity\DoctrineIP;
use DateInterval;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class IPFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $date = new \DateTime();

        $IP = new DoctrineIP();
        $IP->setIP('255.255.255.0');
        $IP->setNbVisit(100);
        $IP->setLastVisit($date->sub(new DateInterval('P1D')));

        $IP1 = new DoctrineIP();
        $IP1->setIP('191.255.255.255');
        $IP1->setNbVisit(10);
        $IP1->setLastVisit($date->sub(new DateInterval('P10D')));

        $IP2 = new DoctrineIP();
        $IP2->setIP('192.168.0.0	');
        $IP2->setNbVisit(20);
        $IP2->setLastVisit($date->sub(new DateInterval('P20D')));

        $IP3 = new DoctrineIP();
        $IP3->setIP('240.0.0.0');
        $IP3->setNbVisit(30);
        $IP3->setLastVisit($date->sub(new DateInterval('P30D')));

        $IP4 = new DoctrineIP();
        $IP4->setIP('198.51.100.0');
        $IP4->setNbVisit(40);
        $IP4->setLastVisit($date->sub(new DateInterval('P40D')));

        $IPs = [$IP, $IP1, $IP2, $IP3, $IP4];

        foreach ($IPs as $IP) {
            $manager->persist($IP);
        }
        $manager->flush();
    }
}