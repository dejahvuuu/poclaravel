<?php

namespace App\Http\Controllers;

use App\Services\DropboxService;
use Illuminate\Http\Request;

class DropboxController extends Controller
{
    protected $dropbox;

    public function __construct(DropboxService $dropbox)
    {
        $this->dropbox = $dropbox;
    }

    public function listTree()
    {
        $tree = $this->dropbox->listTree();

        return response()->json($tree);
    }

    public function countFiles(Request $request)
    {
        $directory = $request->get('directory', '');
        $fileCount = $this->dropbox->countFiles($directory);
    
        return response()->json([
            'message' => 'Conteo de archivos exitoso',
            'directory' => $directory,
            'total_files' => $fileCount
        ]);
    }

    public function debugListContents(Request $request)
    {
        $directory = $request->get('directory', '');
        $contents = $this->dropbox->listFolderContents($directory);

        return response()->json($contents);
    }
    
}
