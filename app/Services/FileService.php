<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService {

    /**
     * Delete file from path
     *
     * @param string $file eg csv, json, txt
     * @param string $path subfolder name
     * @param string $filename
     * @return view
     */
    public function delete(
        string $file, 
        string $path, 
        string $filename
    ) {

        $filename = strip_tags($filename);
        $url = $file . '/' . $path . '/' . $filename . '.'. $file;

        if(Storage::disk('public')->get($url)) {
            return Storage::disk('public')->delete($url);
        }
    }

    /**
     * Delete all files in path
     *
     * @param string $directory path to the folder
     * @return view
     */
    public function deleteAll(string $directory) {

        $files = Storage::disk('public')->files($directory);

        if($files) {
            return Storage::disk('public')->delete($files);
        }
    }

}