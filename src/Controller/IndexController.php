<?php

namespace App\Controller;

use App\Repository\MealsRepository;
use App\Requests\MealsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class IndexController extends AbstractController
{
    private $mealsRequest;
    private $repo;

    public function __construct(MealsRequest $mealsRequest, MealsRepository $repo)
    {
        $this->mealsRequest = $mealsRequest;
        $this->repo = $repo;
    }

    /**
     * @Route("/", name="app_index")
     */
    public function index(Request $request, PaginatorInterface $paginator): JsonResponse
    {
        $parameters = $this->mealsRequest->validate($request);

        $data = $this->repo->getMeals($parameters);

        /**
         * Pagination
         */
        $pagination = $paginator->paginate(
            $data,
            (int) $parameters['page'],
            (int) $parameters['per_page']
        );

        dd($pagination->getItems());

        // $errors = $request->validate();

        // dd($errors);

        // $meals = $em->getRepository(Meals::class)->getMeals();

        // dd($tags[0]->getTagsTranslations()[0]->getLocale());
        // dd($meals);

        // $trans = [];

        // foreach ($meals as $tag) {
        //     $tagsTranslations = $tag->getTagsTranslations();

        //     foreach ($tagsTranslations as $translated) {
        //         $locale = $translated->getLocale();
        //         if ($locale = 'hr') {
        //             $trans[] = $translated;
        //         }
        //     }
        // }

        // dd($trans);

        return $this->json($pagination);
    }
}
