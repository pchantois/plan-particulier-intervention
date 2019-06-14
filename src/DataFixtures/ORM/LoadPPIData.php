<?php //src/DataFixtures/ORM/LoadCategoryData.php

namespace App\DataFixtures\ORM;

use App\Entity\Admin\CodeMaire;
use App\Entity\Admin\NatureOpe;
use App\Entity\Admin\Operation;
use App\Entity\Admin\PolitiquePub;
use App\Entity\Admin\Quartier;
use App\Entity\Admin\RegroupementOpe;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		//$reader = ReaderFactory::create(Type::CSV); // for CSV files
		//$reader = ReaderFactory::create(Type::ODS); // for ODS files

		$reader->open('files/impots.ods');
		$datas = array();

		foreach ($reader->getSheetIterator() as $sheet) {
			$feuille = $sheet->getName();
			$datas[$feuille] = array();
			//$this->qf_generate($feuille, $sheet);
			foreach ($sheet->getRowIterator() as $row) {
				// do stuff with the row
				$datas[$feuille][] = $row;
				//$datas[] = $row;
			}
		}
		//var_dump($datas);

        $reader->close();
        
        foreach ($datas['quartier'] as $data) {
            $item = new Quartier();
            $item->setCode($data[0]);
            $item->setLibelle($data[1]);
            $manager->persist($item);
        }
        
        foreach ($datas['nature'] as $data) {
            $item = new NatureOpe();
            $item->setLibelle($data[1]);
            $manager->persist($item);
        }
        
        foreach ($datas['code maire'] as $data) {
            $item = new CodeMaire();
            $item->setCode($data[0]);
            $item->setLibelle($data[1]);
            $manager->persist($item);
        }
        
        foreach ($datas['politique'] as $data) {
            $item = new PolitiquePub();
            $item->setLibelle($data[1]);
            $manager->persist($item);
        }
        
        foreach ($datas['regroupement'] as $data) {
            $item = new RegroupementOpe();
            $item->setLibelle($data[0]);
            $manager->persist($item);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}