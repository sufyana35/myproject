<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Products
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $ProductCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $ProductName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $ProductDescription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $Stock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $CostGBP;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Discontinued;

    /**
     * Create array object.
     *
     * @param array $data
     * @return Products
     */
    public function createFromArray(array $data): self
    {
        $i = new self();
        $i->ProductCode = $data['Product Code'] ?? null;
        $i->ProductName = $data['Product Name'] ?? null;
        $i->ProductDescription = $data['Product Description'] ?? null;
        $i->Stock = $data['Stock'] ?? null;
        $i->CostGBP = $data['Cost in GBP'] ?? null;
        $i->Discontinued = $data['Discontinued'] ?? null;

        return $i;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductCode(): ?string
    {
        return $this->ProductCode;
    }

    public function setProductCode(?string $ProductCode): self
    {
        $this->ProductCode = $ProductCode;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->ProductName;
    }

    public function setProductName(?string $ProductName): self
    {
        $this->ProductName = $ProductName;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->ProductDescription;
    }

    public function setProductDescription(?string $ProductDescription): self
    {
        $this->ProductDescription = $ProductDescription;

        return $this;
    }

    public function getStock(): ?string
    {
        return $this->Stock;
    }

    public function setStock(?string $Stock): self
    {
        $this->Stock = $Stock;

        return $this;
    }

    public function getCostGBP(): ?string
    {
        return $this->CostGBP;
    }

    public function setCostGBP(?string $CostGBP): self
    {
        $this->CostGBP = $CostGBP;

        return $this;
    }

    public function getDiscontinued(): ?string
    {
        return $this->Discontinued;
    }

    public function setDiscontinued(?string $Discontinued): self
    {
        $this->Discontinued = $Discontinued;

        return $this;
    }
}
