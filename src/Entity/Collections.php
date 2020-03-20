<?php

namespace App\Entity;

class Collections
{
    private $SuccessUploadedProductsCollections;
    private $FailureUploadedProductsCollections;

    /**
     * @return mixed
     */
    public function getSuccessUploadedProductsCollections()
    {
        return $this->SuccessUploadedProductsCollections;
    }

    /**
     * @param mixed $SuccessUploadedProductsCollections
     */
    public function setSuccessUploadedProductsCollections($SuccessUploadedProductsCollections): void
    {
        $this->SuccessUploadedProductsCollections = $SuccessUploadedProductsCollections;
    }

    /**
     * @return mixed
     */
    public function getFailureUploadedProductsCollections()
    {
        return $this->FailureUploadedProductsCollections;
    }

    /**
     * @param mixed $FailureUploadedProductsCollections
     */
    public function setFailureUploadedProductsCollections($FailureUploadedProductsCollections): void
    {
        $this->FailureUploadedProductsCollections = $FailureUploadedProductsCollections;
    }
}
