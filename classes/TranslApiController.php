<?php
/**
 * Created by PhpStorm.
 * User: Łukasz Biały
 * URL: http://keios.eu
 * Date: 6/13/15
 * Time: 6:20 AM
 */

namespace Keios\Apparatus\Classes;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use October\Rain\Translation\Translator;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TranslApiController
 *
 * @package Keios\Apparatus\Classes
 */
class TranslApiController extends Controller
{

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * TranslApiController constructor.
     *
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|JsonResponse
     */
    public function getTranslations(Request $request)
    {
        $data = $request->request->all();

        if (!isset($data['keys'])) {
            return new RedirectResponse('/404');
        }

        $translations = [];

        $keysToTranslate = $data['keys'];

        foreach ($keysToTranslate as $key) {
            $translations[$key] = $this->translator->get($key);
        }

        return new JsonResponse($translations, 200);
    }
}