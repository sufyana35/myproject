<?php

namespace App\Service\Validation;

use App\Entity\Collections;
use App\Entity\FailedProducts;
use App\Entity\Products;
use App\Service\RabbitMQ\send;

class ValidatorFunction extends Collections
{
    public function validation($data, $fileId)
    {
        //validation functions
        $numberFormatter = new NumberFormatter();
        $booleanFormatter = new BooleanFormatter();
        $RabitMqSender = new send();

        //Put array into entity collections
        $products = new Products();
        foreach ($data as $key => $records) {
            //set entity values
            $uploadedProductsCollection[] = $products->createFromArray($records);
        }

        //Loop collection entities and validate
        foreach ($uploadedProductsCollection as $item) {
            //pre-data validation and formatter
            $item->setStock($numberFormatter->numberFormatter($item->getStock()));
            $item->setCostGBP($numberFormatter->numberFormatter($item->getCostGBP()));
            $item->setDiscontinued($booleanFormatter->booleanFormatter($item->getDiscontinued()));

            //check if fields are empty
            if ('' == $item->getCostGBP() || '' == $item->getStock()) {
                $failureUploadedProductsCollections[] = new FailedProducts(
                    $item->getProductCode(),
                    $item->getProductName(),
                    $item->getProductDescription(),
                    $item->getStock(),
                    $item->getCostGBP(),
                    $item->getDiscontinued(),
                    $fileId,
                    'Missing Stock field or Cost Field');
            } else {
                //Any stock item which costs more than £1000 will not be imported
                //Any stock item which costs less that £5 and has less than 10 stock will not be imported.
                if ($item->getCostGBP() < 5 && $item->getStock() < 10 || $item->getCostGBP() >= 1000) {
                    $failureUploadedProductsCollections[] = new FailedProducts(
                        $item->getProductCode(),
                        $item->getProductName(),
                        $item->getProductDescription(),
                        $item->getStock(),
                        $item->getCostGBP(),
                        $item->getDiscontinued(),
                        $fileId,
                        'Not imported due to validation rules');
                } else {
                    $successUploadedProductsCollections[] = $item; //success
                    //$RabitMqSender->sender($item);
                }
            }
        }

        $this->setSuccessUploadedProductsCollections($successUploadedProductsCollections);
        $this->setFailureUploadedProductsCollections($failureUploadedProductsCollections);
        //dd($failureUploadedProductsCollections);
    }
}
