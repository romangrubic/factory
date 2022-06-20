<?php

/**
 * This file contains IndexController class (main controller class)
 */

namespace App\Controller;

use App\{Repository\MealsRepository,
    Requests\MealsRequest};
use App\Services\Format\FormatResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse,
    Request};
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * IndexController class is a controller class for route "/api/meals"
 */
class IndexController extends AbstractController
{    
    /**
     * Setting properties
     *
     */
    private MealsRequest $mealsRequest;
    private MealsRepository $repo;
    private PaginatorInterface $paginator;
    private FormatResponse $formatResponse;
    private EntityManagerInterface $em;
    
    /**
     * __construct
     *
     * @param  MealsRequest $mealsRequest
     * @param  MealsRepository $repo
     * @param  PaginatorInterface $paginator
     * @param  FormatResponse $formatResponse
     * @return void
     */
    public function __construct(MealsRequest $mealsRequest, 
                                MealsRepository $repo, 
                                PaginatorInterface $paginator, 
                                FormatResponse $formatResponse,
                                EntityManagerInterface $em)
    {
        $this->mealsRequest = $mealsRequest;
        $this->repo = $repo;
        $this->paginator = $paginator;
        $this->formatResponse = $formatResponse;
        $this->em = $em;
    }

    /**
     * @Route("/api/meals", name="app_index")
     */
    public function index(Request $request)
    {
        /**
         * Validate parameters
         */
        $parameters = $this->mealsRequest->validate($request);

        /**
         * Get meals data query
         */
        $data = $this->repo->getMeals($parameters);

        // $data = $this->repo->findAll();

        /**
         * Paginate data query and get results
         */
        $pagination = $this->paginator->paginate($data, 
                                            (int) $parameters['page'], 
                                            (int) $parameters['per_page']);

        /**
         * Format response data
         */
        $formattedMeals = $this->formatResponse->formatResponse($parameters, $pagination, $request);

        /**
         * Return json data to User
         */
        // return $this->json($formattedMeals);

        return $formattedMeals;
    }
}
