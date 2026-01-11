<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Upload temporary media (supports chunking)
     */
    public function upload(\Illuminate\Http\Request $request): JsonResponse
    {
        $file = $request->file('file');
        $chunkIndex = $request->input('dzchunkindex');
        $totalChunks = $request->input('dztotalchunkcount');
        $uuid = $request->input('dzuuid');

        if ($totalChunks !== null) {
            $tempPath = "temp/chunks/{$uuid}";
            $chunkName = "{$chunkIndex}.part";

            \Illuminate\Support\Facades\Storage::disk('local')->putFileAs($tempPath, $file, $chunkName);

            // Check if all chunks are uploaded
            $chunks = \Illuminate\Support\Facades\Storage::disk('local')->files($tempPath);
            if (count($chunks) == $totalChunks) {
                // Merge chunks
                $originalName = $request->input('dzfilename');
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $finalName = \Illuminate\Support\Str::random(40) . ($extension ? '.' . $extension : '');
                $finalDir = 'temp/' . date('Y-m-d');
                $finalPath = "{$finalDir}/{$finalName}";

                if (!\Illuminate\Support\Facades\Storage::disk('local')->exists($finalDir)) {
                    \Illuminate\Support\Facades\Storage::disk('local')->makeDirectory($finalDir);
                }

                $out = fopen(\Illuminate\Support\Facades\Storage::disk('local')->path($finalPath), "wb");
                for ($i = 0; $i < $totalChunks; $i++) {
                    $chunkFile = \Illuminate\Support\Facades\Storage::disk('local')->path("{$tempPath}/{$i}.part");
                    // Wait slightly if file is still being written by another process (unlikely but possible)
                    $in = fopen($chunkFile, "rb");
                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }
                    fclose($in);
                    @unlink($chunkFile);
                }
                fclose($out);
                \Illuminate\Support\Facades\Storage::disk('local')->deleteDirectory($tempPath);

                return response()->json([
                    'path' => $finalPath,
                    'name' => $originalName,
                    'success' => true
                ]);
            }

            return response()->json(['chunk' => $chunkIndex, 'success' => true]);
        }

        // Single file upload
        $tempDir = 'temp/' . date('Y-m-d');
        $tempName = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($tempDir, $tempName, 'local');

        return response()->json([
            'path' => $path,
            'name' => $file->getClientOriginalName(),
            'success' => true
        ]);
    }

    /**
     * Remove temporary media
     */
    public function removeTemp(\Illuminate\Http\Request $request): JsonResponse
    {
        $path = $request->input('path');
        if ($path && \Illuminate\Support\Facades\Storage::disk('local')->exists($path)) {
            \Illuminate\Support\Facades\Storage::disk('local')->delete($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Path not found'], 404);
    }

    /**
     * Remove the specified media from storage
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->productService->removeMedia($id);

        if (!$deleted) {
            return response()->json(['success' => false, 'message' => 'Media not found'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Media deleted successfully']);
    }
}
