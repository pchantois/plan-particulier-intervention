<?php

namespace App\Entity\Objet;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Objet\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	public function getId():  ? int {
		return $this->id;
	}
}
