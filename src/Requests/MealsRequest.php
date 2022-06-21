<?php

namespace App\Requests;

use App\Repository\LanguagesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MealsRequest
{
    private $validator;
    private $repo;

    public function __construct(ValidatorInterface $validator, LanguagesRepository $repo)
    {
        $this->validator = $validator;
        $this->repo = $repo;
    }

    public function validate(Request $request)
    {
        /**
         * Allow only codes that exist in languages table
         */
        $languages = $this->repo->findAll();
        $codeRegex = '';
        foreach ($languages as $language) {
            $codeRegex .= '|'.$language->getCode();
        }

        $lang = $request->query->get('lang');
        $with = $request->query->get('with');
        $category = $request->query->get('category');
        $tags = $request->query->get('tags');
        $per_page = $request->query->get('per_page');
        $page = $request->query->get('page');
        $diff_time = $request->query->get('diff_time');


        $input = [
            'lang' => $lang,
            'with' => $with,
            'category' => $category,
            'tags' => $tags,
            'per_page' => $per_page ?? 10,
            'page' => $page ?? 1,
            'diff_time' => $diff_time,
            ];

        $constraints = new Assert\Collection([
            'lang' => [
                new Assert\Regex([
                    'pattern' => '/^('. $codeRegex . ')$/'
                ]),
                new Assert\NotBlank
            ],
            'with' => [
                new Assert\Optional,
                new Assert\Regex([
                'pattern' => '/^((tags|ingredients|category)+,?){1,3}$/'
                ])
            ],
            'category' => [
                new Assert\Optional,
                new Assert\Regex([
                'pattern' => '/^(?:[1-9][0-9]*|NULL|!NULL)$/'
                ])
            ],
            'tags' => [
                new Assert\Optional,
                new Assert\Regex([
                'pattern' => '/^\d+(?:,\d+)*$/'
                ])
            ],
            'per_page' => [
                new Assert\Optional,
                new Assert\Positive
            ],
            'page' => [
                new Assert\Optional,
                new Assert\Positive
            ],
            'diff_time' => [
                new Assert\Optional,
                new Assert\Regex([
                'pattern' => '/^\d+$/'
                ])
            ],

        ]);



        $errors = $this->validator->validate($input, $constraints);
        // dd($violations);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;
    
            dd($errorsString);
        }
    
        return array_filter($input);
    }
}