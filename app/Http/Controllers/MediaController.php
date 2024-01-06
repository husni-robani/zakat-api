<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class MediaController extends Controller
{
    use ApiResponses;
    public function show($mediaId){
        try {
            $media = Media::find($mediaId);
        }catch (\Exception $exception){
            return $this->responseFailed(
                'Failed to get media by id',
                404,
                $exception->getMessage()
            );
        }
        return Media::find($mediaId);
    }
    public function destroy($mediaId){
        try {
            $media = Media::find($mediaId);
            $media->delete();
        }catch (\Exception $exception){
            return $this->responseFailed(
                'Failed to delete media',
                404,
                $exception->getMessage()
            );
        }
        return response('', 204);
    }
}
