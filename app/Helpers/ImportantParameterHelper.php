<?php

namespace App\Helpers;

use App\Models\ImportantParameter as ModelsImportantParameterModel;
use App\Services\LanguageService;

class ImportantParameterHelper
{


    /**
     * Get values based on the selected language.
     *
     * @param string $key
     * @return array

     **/

    public static function getValues($key)
    {

        $locale = LanguageService::getLocale();
        ///$locale = $this->locale ;

        $parameter = ModelsImportantParameterModel::where('key', $key)->get();

        if (!$parameter) {
            return [];
        }

        $list = [];
        foreach ($parameter as $item) {

            $lable = '';

            switch ($locale) {
                case 'en':
                    $lable = $item->label_en;
                    break;
                case 'ta':
                    $lable = $item->label_ta;
                    break;
                case 'si':
                    $lable = $item->label_si;
                    break;
            }

            $list[$item->slug] =  $lable;
        }

        return $list;
    }
}
