<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\StorageService;
use App\Http\Requests\FileRequest;
use App\Http\Requests\FileUpdateRequest;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected readonly File $file;
    protected readonly StorageService $storage_service;
    protected readonly string $file_path;

    public function __construct(File $file, StorageService $storage_service)
    {
        $this->file = $file;
        $this->storage_service = $storage_service;
        $this->file_path = "files/";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $files = $this->file->all();
            if ($files->count() > 0) {
                foreach ($files as $item) {
                    $item->file_url = $this->storage_service->getAwsFile($this->file_path, $item->filename);
                    $item->extension = "." . substr(strrchr($item->filename, "."), 1);
                }
            }
            return response()->json(['files' => $files]);
        } catch (\Exception $e) {
            \Log::error('Error occurred while uploading the file: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching files.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileRequest $request)
    {
        try {
            $this->storage_service->saveAwsFile($this->file_path, $request->filename);
            $this->file->create([
                'filename'      =>  $request->filename->getClientOriginalName(),
                'description'   =>  $request->description
            ]);
            return response()->json(['message' => 'File uploaded successfully'], 201);
        } catch (\Exception $e) {
            \Log::error('Error occurred while uploading the file: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while uploading file.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FileUpdateRequest $request, File $file)
    {
        try {
            $data = $request->all();
            if ($request->filename) {
                $this->storage_service->deleteAwsFile($this->file_path, $file->filename);
                $this->storage_service->saveAwsFile($this->file_path, $request->filename);
                $data['filename'] = $request->filename->getClientOriginalName();
            }
            $file->update($data);
            return response()->json(['message' => 'File updated successfully']);
        } catch (\Exception $e) {
            \Log::error('Error occurred while uploading the file: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating file.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        try {
            $this->storage_service->deleteAwsFile($this->file_path, $file->filename);
            $file->delete();
            return response()->json(['message' => 'File deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Error occurred while uploading the file: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting file.'], 500);
        }
    }
}
