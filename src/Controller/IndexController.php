<?php

namespace App\Controller;

use App\Repository\MealsRepository;
use App\Requests\MealsRequest;
use App\Services\Format\Item;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class IndexController extends AbstractController
{
    private $mealsRequest;
    private $repo;
    private $paginator;
    private $item;

    public function __construct(MealsRequest $mealsRequest, MealsRepository $repo, PaginatorInterface $paginator, Item $item)
    {
        $this->mealsRequest = $mealsRequest;
        $this->repo = $repo;
        $this->paginator = $paginator;
        $this->item = $item;
    }

    /**
     * @Route("/", name="app_index")
     */
    public function index(Request $request): JsonResponse
    {
        /**
         * Validate parameters
         */
        $parameters = $this->mealsRequest->validate($request);

        /**
         * Get meals data
         */
        $data = $this->repo->getMeals($parameters);

        /**
         * Paginate data
         */
        $pagination = $this->paginator->paginate(
            $data,
            (int) $parameters['page'],
            (int) $parameters['per_page']
        );

        /**
         * Format meals
         */
        $formattedMeals = $this->item->toArray($pagination->getItems(), $parameters);
// dd($formattedMeals);
        // $errors = $request->validate();


        return $this->json($formattedMeals);
    }

}
