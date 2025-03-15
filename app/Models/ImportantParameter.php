<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Services\LanguageService;

class ImportantParameter extends Model
{
    use HasFactory;

    protected $table = 'important_parameters';

    protected $fillable = [
        'key',
        'slug',
        'label_si',
        'label_ta',
        'label_en',
    ];

    /**
     * Get values based on the selected language.
     *
     * @param string $key
     * @return array
     */
    public static function getValues($key)
    {
        $parameter = self::where('key', $key)->list();
        $locale = LanguageService::getLocale();

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
                    $lable = $item->label_esi;
                break;
            }

            $list[$item['slug']] =  $lable;
        }

        return $list;
    }
}
