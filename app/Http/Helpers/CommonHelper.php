<?php

namespace App\Http\Helpers;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CommonHelper
{
    /**
     * @param string $folder
     * @param UploadedFile $file
     * @return false|string
     */
    public function uploadedFile(string $folder, UploadedFile $file)
    {
        $name = $file->getClientOriginalName();
        $date = new Carbon();
        $date->locale('en');
        $folder = "$folder/" . $date->monthName . $date->year;

        if (!File::exists(public_path('storage/' . $folder))) {
            File::makeDirectory(public_path('storage/' . $folder), 0755, true);
        }

        $path = $file->store('public/' . $folder);

        return json_encode([[
            'download_link' => Str::after($path, 'public'),
            'original_name' => $name,
        ]]);
    }

    /**
     * @param string $jsonString
     */
    public function deleteFile(string $jsonString)
    {
        if (empty($jsonString))
            return;

        $path = json_decode($jsonString, true);
        if (!empty($path[0]['download_link']))
            File::delete(public_path('storage/' . $path[0]['download_link']));
    }
}
