<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Spatie\Dropbox\Client;

class DropboxService
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client(env('DROPBOX_ACCESS_TOKEN'));
    }

    public function listFiles($directory = '')
    {
        return Storage::disk('dropbox')->allFiles($directory);
    }

    public function listDirectories($directory = '')
    {
        return Storage::disk('dropbox')->allDirectories($directory);
    }

    public function listTree($directory = '')
    {
        $allFiles = Storage::disk('dropbox')->allFiles($directory);
        $allDirectories = Storage::disk('dropbox')->allDirectories($directory);

        return [
            'directories' => $allDirectories,
            'files' => $allFiles,
        ];
    }
    
    public function listFolderContents($directory = '')
    {
        try {

            $path = trim($directory) ? '/' . trim($directory, '/') : '';
            $result = $this->client->listFolder($path, true); 
            return $result;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function countFiles($directory = '')
    {
        $path = trim($directory) ? '/' . trim($directory, '/') : '';

        $entries = $this->client->listFolder($path, true);

        $files = array_filter($entries['entries'], function ($entry) {
            return $entry['.tag'] === 'file';
        });

        return count($files);
    }

}
