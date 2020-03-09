<?php //src/DataFixtures/ORM/LoadPPIData.php

namespace App\DataFixtures\ORM;

use App\Entity\Admin\CodeMaire;
use App\Repository\Admin\CodeMaireRepository;
use App\Entity\Admin\NatureOpe;
use App\Repository\Admin\NatureOpeRepository;
use App\Entity\Admin\Operation;
use App\Entity\Admin\OperationData;
use App\Entity\Admin\PolitiquePub;
use App\Repository\Admin\PolitiquePubRepository;
use App\Entity\Admin\Quartier;
use App\Repository\Admin\QuartierRepository;
use App\Entity\Admin\RegroupementOpe;
use App\Repository\Admin\RegroupementOpeRepository;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Box\Spout\Common\Type;
//use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class LoadPPIData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->load_ppi($manager);
        $this->load_ppi2($manager);
    }
    
    public function load_ppi(ObjectManager $manager)
    {
		//$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		//$reader = ReaderFactory::create(Type::CSV); // for CSV files
        //$reader = ReaderFactory::create(Type::ODS); // for ODS files
        $reader = ReaderEntityFactory::createReaderFromFile(__DIR__.'/../../../public/files/entries_ppi.xlsx');
        $reader->open(__DIR__.'/../../../public/files/entries_ppi.xlsx');

		$datas = array();

		foreach ($reader->getSheetIterator() as $sheet) {
			$feuille = $sheet->getName();
			$datas[$feuille] = array();
			//$this->qf_generate($feuille, $sheet);
			foreach ($sheet->getRowIterator() as $row) {
				// do stuff with the row
				$datas[$feuille][] = $row->getCells();
				//$datas[] = $row;
			}
		}
		//var_dump($datas);

        $reader->close();
        //var_dump($datas);
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

    public function load_ppi2(ObjectManager $manager)
    {
		//$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		//$reader = ReaderFactory::create(Type::CSV); // for CSV files
		//$reader = ReaderFactory::create(Type::ODS); // for ODS files
        $reader = ReaderEntityFactory::createReaderFromFile(__DIR__.'/../../../public/files/PPI_2020.xlsx');
        $reader->open(__DIR__.'/../../../public/files/PPI_2020.xlsx');

		$datas = array();

		foreach ($reader->getSheetIterator() as $sheet) {
            $feuille = $sheet->getName();
            if ($feuille != 'PPI A MODIFIER')
            {
                continue;
            }
			$datas[$feuille] = array();
            //$this->qf_generate($feuille, $sheet);
            $first = true;
			foreach ($sheet->getRowIterator() as $row) {
                // do stuff with the row
                if ($first) {
                    $first = false;
                    continue;
                }
				$datas[$feuille][] = $row->getCells();
				//$datas[] = $row;
			}
		}
		//var_dump($datas);

        $reader->close();
        
        foreach ($datas['PPI A MODIFIER'] as $data) {
            $operation = new Operation();
            $operation->setCode($data[8]);
            $operation->setLibelle($data[9]);
            $operation->setRegroupementOpe($manager->getRepository(RegroupementOpe::class)->findOneBy(['libelle' => $data[10]]));
            $operation->setNatureOpe($manager->getRepository(NatureOpe::class)->findOneBy(['libelle' => $data[11]]));
            $operation->setQuartier($manager->getRepository(Quartier::class)->findOneBy(['libelle' => $data[12]]));
            $operation->setPolitiquePub($manager->getRepository(PolitiquePub::class)->findOneBy(['libelle' => $data[13]]));
            $operation->setCodeMaire($manager->getRepository(CodeMaire::class)->findOneBy(['libelle' => $data[14]]));
            $operation->setDescription($data[51]);
            $operation->setCommentaire($data[52]);
            $operation->setDob(true);
            $operation->setRecueil(true);
            $manager->persist($operation);

            $annee = 2018;
            $type = false;
            foreach (range(1,15) as $compteur)
            {
                if ($compteur % 3 == 0)
                {
                    $annee++;
                    continue;
                }
                $item = new OperationData();
                $item->setOperation($operation);
                $item->setMontant(intval($data[28+$compteur]->__toString()));
                $item->setAnnee($annee);
                $type = !$type;
                $item->setType($type);
                $manager->persist($item);
            }
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}