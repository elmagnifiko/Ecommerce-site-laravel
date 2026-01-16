<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            // Sauvegarder dans storage/app/public/products
            $path = $image->storeAs('products', $imageName, 'public');
            
            // URL accessible publiquement
            $url = asset('storage/' . $path);

            return response()->json([
                'success' => true,
                'message' => 'Image uploadée avec succès',
                'data' => [
                    'path' => $path,
                    'url' => $url,
                    'filename' => $imageName
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'upload',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        try {
            if (Storage::disk('public')->exists($request->path)) {
                Storage::disk('public')->delete($request->path);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Image supprimée avec succès'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Image non trouvée'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function show($filename)
{
    $path = storage_path('app/public/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    return response()->file($path);
}
}