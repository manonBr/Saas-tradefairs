<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use ZipArchive;

class FileController extends Controller
{
    /**
     * Download file from path
     *
     * @param string $file eg csv, json, txt
     * @param string $path subfolder name
     * @param string $filename
     * @return view
     */
    public static function download(
        string $file, 
        string $path, 
        string $filename
    ) {

        $filename = strip_tags($filename);
        $url = $file . '/' . $path . '/' . $filename . '.'. $file;

        if(Storage::disk('public')->get($url)) {
            return Storage::disk('public')->download($url);
        }

        return redirect()->route('404');
        
    }

    /**
     * Download every files in path
     *
     * @param string $path - without closing slash
     * @param string $zipFileName - with extension
     */
    public static function downloadAll(
        string $path,
        string $zipFileName
    ) {

        $zip = new ZipArchive;
        $storagePath = storage_path('app/public/' . $path . '/');
        $filesToZip = Storage::disk('public')->files($path);

        if ($zip->open(storage_path('app/public/' . $path . '/'.$zipFileName), ZipArchive::CREATE) === TRUE) {

            foreach ($filesToZip as $file) {
                $filePath = $storagePath . basename($file);
                $zip->addFile($filePath, basename($file));
            }

            $zip->close();

            return response()->download(storage_path('app/public/' . $path . '/'.$zipFileName))->deleteFileAfterSend(true);

        } else {
            throw new Exception("La création de l'archive a échouée");
        }

    }
 
}
