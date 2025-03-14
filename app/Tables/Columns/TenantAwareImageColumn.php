<?php

namespace App\Tables\Columns;

use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TenantAwareImageColumn extends SpatieMediaLibraryImageColumn
{

   public function getImageUrl(?string $state = null): ?string
    {
        // Get the media model associated with the column
        $media = $this->getMediaModel();

        if (!$media) {
            return null;
        }

        // Get the tenant ID and subdomain (replace with your logic)
        //$tenantId = app('tenant.context')->getId(); // Example: 1
        //$tenantSubdomain = app('tenant.context')->getSubdomain(); // Example: http://tenant1.mt.local
        $tenantSubdomain = 'http://tenant1.mt.local';


        $id = $media->getAttribute('id');
        $model_id = $media->getAttribute('model_id');
        $file_name = $media->getAttribute('file_name');

        $url = $tenantSubdomain . '/storage/tenant/' . $id .'/'. $file_name;

        return $url;
    }

    protected function getMediaModel(): ?Media
    {
        // Retrieve the media model associated with the column
        return $this->getRecord()->getFirstMedia($this->getCollection());
    }
}
