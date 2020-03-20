<?php

namespace App\Controller;

use App\Form\UploadProductsFormType;
use App\Service\UploaderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadProductsController extends AbstractController
{
    /**
     * @Route("/upload/products", name="upload_products")
     *
     * @param Request $request
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function uploadProducts(Request $request, UploaderHelper $uploaderHelper)
    {
        $form = $this->createForm(UploadProductsFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['UploadFile']->getData(); //GET DATA FROM FORM
            if ($uploadedFile instanceof UploadedFile) {
                $upload = $uploaderHelper->uploadFile($uploadedFile, $this->getParameter('csv_directory'));

                //upload file name to Database
                $em = $this->getDoctrine()->getManager();
                $em->persist($upload);
                $em->flush();

                return $this->redirectToRoute('product_report', ['uploadId' => $upload->getId()]);
            }
        }

        return $this->render('upload_products/index.html.twig', [
            'uploadProductsForm' => $form->createView(),
            'controller_name' => 'Upload Product',
        ]);
    }
}
