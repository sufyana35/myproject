<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Upload;
use App\Service\Validation\ValidatorFunction;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ProcessUploadedFileCommand extends Command
{
    private $doctrine;
    private $entityManager;
    private $serializer;
    private $managerRegistry;

    public function __construct($name, Registry $doctrine, SerializerInterface $serializer, EntityManagerInterface $entityManager, ManagerRegistry $managerRegistry)
    {
        parent::__construct($name);

        $this->doctrine = $doctrine;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->managerRegistry = $managerRegistry;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $uploads = $this->doctrine->getRepository(Upload::class)->findBy(['processed' => false]); //find all non processed files

        foreach ($uploads as $upload) { //loop over uploads
            $path = $upload->getPath(); //get file path
            $fileId = $upload->getId(); //get file ID

            $this->processFile($path, $fileId); //execute processFile function
            //sleep(60); //for testing purposes

            $upload->processed(); //Set processed file to true '1'
            $this->entityManager->flush(); //Update Database
        }
        // php bin/console app:file_upload:process

        $output->writeln('Success');

        return 1;
    }

    public function processFile($path, $fileId)
    {
        //$failedProduct = new FailedProducts();
        $validatorFunction = new ValidatorFunction(); //validation functions
        $entityManager = $this->entityManager;

        //File upload code
        $destination = 'public/uploads/csv'; //get upload directory parameter from services.yml
        $directory = $destination.'/'.$path; //Set File Path for decode

        //Decode File
        $data = $this->serializer->decode(file_get_contents($directory), 'csv'); //Read File

        //Validation function
        $validatorFunction->validation($data, $fileId); //class file -> do function (pass decoded file array)

        //Handing doctrine uploads and databases
        foreach ($validatorFunction->getSuccessUploadedProductsCollections() as $item) {
            $entityManager->persist($item);
        }

        foreach ($validatorFunction->getFailureUploadedProductsCollections() as $item) {
            $entityManager->persist($item);
        }

    }

}
