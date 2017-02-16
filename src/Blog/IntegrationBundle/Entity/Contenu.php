<?php

namespace Blog\IntegrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
//use Symfony\Component\Validator\Constraints as Assert;
//use EmauxBundle\Validator\Constraints as EmauxAssert;
//use Symfony\Component\Validator\Context\ExecutionContextInterface;



/**
 * Contenu
 *
 * @ORM\Table(name="contenu")
 * @ORM\Entity(repositoryClass="Blog\IntegrationBundle\Repository\ContenuRepository")
 */
class Contenu
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Blog\IntegrationBundle\Entity\Categorie", inversedBy="contenu")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categorie;
   
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description_text", type="text", nullable=true)
     */
    private $descriptionText;
    
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="text", nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="id_etat", type="boolean", nullable=true)
     */
    private $id_etat;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable = true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable = true)
     */
    private $updatedAt;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descriptionText
     *
     * @param string $descriptionText
     *
     * @return Contenu
     */
    public function setDescriptionText($descriptionText)
    {
        $this->descriptionText = $descriptionText;

        return $this;
    }

    /**
     * Get descriptionText
     *
     * @return string
     */
    public function getDescriptionText()
    {
        return $this->descriptionText;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Contenu
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Contenu
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set idEtat
     *
     * @param boolean $idEtat
     *
     * @return Contenu
     */
    public function setIdEtat($idEtat)
    {
        $this->id_etat = $idEtat;

        return $this;
    }

    /**
     * Get idEtat
     *
     * @return boolean
     */
    public function getIdEtat()
    {
        return $this->id_etat;
    }

    /**
     * Set categorie
     *
     * @param \IntegrationBundle\Entity\Categorie $categorie
     *
     * @return Contenu
     */
    public function setCategorie(\IntegrationBundle\Entity\Categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \IntegrationBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Contenu
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Contenu
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
