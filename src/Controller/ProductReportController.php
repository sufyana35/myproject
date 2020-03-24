<?php

namespace App\Controller;

use App\Entity\FailedProducts;
use App\Entity\Products;
use App\Entity\Upload;
use App\Form\AllProductsType;
use App\Repository\ProductsRepository;
use FOS\ElasticaBundle\FOSElasticaBundle;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Predis\Client;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class ProductReportController extends Controller
{
    /**
     * @Route("/product/report/{uploadId}", name="product_report")
     *
     * @param int $uploadId
     * @return Response
     */
    public function productReport(int $uploadId)
    {
        return $this->render('product_report/index.html.twig', [
            'controller_name' => 'Product Report Status',
            'uploadId' => $uploadId,
        ]);
    }

    /**
     * @Route("/product/report/{uploadId}/state", name="product_report_state")
     * @param int $uploadId
     * @return JsonResponse
     */
    public function uploadState(int $uploadId): JsonResponse
    {
        $upload = $this->getDoctrine()->getRepository(Upload::class)->find($uploadId);

        return new JsonResponse([
           'processed' => $upload->getProcessed(),
        ]);
    }

    /**
     * @Route("/product/summary/{fileId}", name="product_report_summary")
     *
     * @param $fileId
     *
     * @return Response
     */
    public function productReportSummary($fileId)
    {
        $products = $this->getDoctrine()->getRepository(FailedProducts::class)->findBy(['FileId' => $fileId]);

        return $this->render('product_report/product_report_summary.html.twig', [
            'controller_name' => 'Product Report Summary',
            'products' => $products,
        ]);
    }

    /**
     * @Route("/products", name="products")
     *
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param ProductsRepository $repository
     * @param AdapterInterface $cache
     * @return Response
     *
     * @throws InvalidArgumentException
     */
    public function products(PaginatorInterface $paginator, Request $request, ProductsRepository $repository, AdapterInterface $cache)
    {
        $form = $this->createForm(AllProductsType::class);

        $products = $this->getDoctrine()->getRepository(Products::class)->findAll();
        $queryBuilder = $repository->findAll();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form['search']->getData(); //GET DATA FROM FORM


            $finder = $this->container->get('fos_elastica.finder.app.user');
            $paginator = $this->get('knp_paginator');
            $results = $finder->createPaginatorAdapter($search);
            $pagination = $paginator->paginate(
                $results, /* query NOT result */
                $request->query->getInt('page', 1)  /*page number*/,
                12  /*limit per page*/
            );

            return $this->render('product_report/product_database_summary.html.twig', [
                'controller_name' => 'Products in Database',
                'products' => $products,
                'pagination' => $pagination,
                'allProductsType' => $form->createView(),
            ]);
        }

        //PREDIS
        //$client = new Client();
        //$client->set('foo', 'bar');
        //$value = $client->get('foo');
        //dd($value);

        //Cache
        $client = RedisAdapter::createConnection(
            'redis://localhost'
        );

        //$cache = new RedisAdapter($client);
        $item = $cache->getItem('test');
        if (!$item->isHit()) {
            $item->set($products);
            $cache->save($item);
        }
        $cached = $item->get();

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );

        return $this->render('product_report/product_database_summary.html.twig', [
            'controller_name' => 'Products in Database',
            'products' => $cached,
            'pagination' => $pagination,
            'allProductsType' => $form->createView(),
        ]);
    }

    /**
     * @Route("/products/{productId}", name="single_product")
     *
     * @param $productId
     *
     * @return Response
     */
    public function singleProducts($productId)
    {
        $product = $this->getDoctrine()->getRepository(Products::class)->find($productId);

        return $this->render('product_report/single_product.html.twig', [
            'controller_name' => 'View All Products',
            'product' => $product,
        ]);
    }
}
