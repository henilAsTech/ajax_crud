<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('navbar')) {
    function navbar(...$routeNames) {
        foreach ($routeNames as $routeName) {
            if (Route::currentRouteNamed($routeName)) {
                return 'active';
            }
        }
        return '';
    }
}

if (!function_exists('fileUploader')) {
    function fileUploader($file, $path, $old = null)
    {
        $file_name = str()->uuid() . '.' . $file->extension();
        if (in_array($file->extension(), ['jpeg', 'jpg', 'png', 'webp', 'pdf', 'docx', 'xls', 'csv'])) { 
            $storagePath = public_path('app/public/'.$path);
            
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0777, true);
            }

            $filePath = $storagePath . '/' . $file_name;
            file_put_contents($filePath, $file);
            return $file_name;
        }
    }
}