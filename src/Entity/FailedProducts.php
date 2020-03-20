<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FailedProductsRepository")
 */
class FailedProducts extends Products
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $FileId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $FailedNote;

    /**
     * Products constructor.
     * @param $ProductCode
     * @param $ProductName
     * @param $ProductDescription
     * @param $Stock
     * @param $CostGBP
     * @param $Discontinued
     * @param $FileId
     * @param $FailedNote
     */
    public function __construct($ProductCode, $ProductName, $ProductDescription, $Stock, $CostGBP, $Discontinued, $FileId, $FailedNote)
    {
        $this->ProductCode = $ProductCode;
        $this->ProductName = $ProductName;
        $this->ProductDescription = $ProductDescription;
        $this->Stock = $Stock;
        $this->CostGBP = $CostGBP;
        $this->Discontinued = $Discontinued;
        $this->FileId = $FileId;
        $this->FailedNote = $FailedNote;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileId(): ?int
    {
        return $this->FileId;
    }

    public function setFileId(int $FileId): self
    {
        $this->FileId = $FileId;

        return $this;
    }

    public function getFailedNote(): ?string
    {
        return $this->FailedNote;
    }

    public function setFailedNote(?string $FailedNote): self
    {
        $this->FailedNote = $FailedNote;

        return $this;
    }
}
