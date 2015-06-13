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

class TranslApiController extends Controller
{

    protected $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

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