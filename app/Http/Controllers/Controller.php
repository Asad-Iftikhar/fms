<?php

namespace App\Http\Controllers;

use App\Models\Media\Media;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Update the avatar for the user.
     *
     * @param  $image
     * @param string $upload_path
     * @param string $name
     * @return integer
     */
    protected function upload_file ( $image, $upload_path='/', $name='image_' ): int
    {
        $imageName = $name.time().'.'.$image->extension();
        $filePath = $upload_path. $imageName;
        Storage::disk('public')->put($filePath, file_get_contents($image));
        $path = Storage::disk('public')->url($filePath);

        $media = new Media;
        $media->name = $imageName;
        $media->file_path = $upload_path;
        $media->url_file = $path;
        if ($media->save()) {
           return $media->id;
        }
        return 0;
    }

    /**
     * Delete Image from db and storage.
     *
     * @param  integer $id
     * @return void
     */
    protected function remove_file ( $id ): void
    {
        $media_row = Media::find($id);
        if(!empty($media_row)){
            Storage::disk('public')->delete($media_row->file_path.$media_row->name);
            $media_row->delete();
        }

    }
}
