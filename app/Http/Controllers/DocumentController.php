<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class DocumentController
 * @package App\Http\Controllers
 */
class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $documents = Document::query()
            ->orderByDesc('created_at')
            ->paginate(20);

        return $this->json(compact('documents'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if (($pdf = $request->file('pdf')) !== null) {
            /** @var Document $document */
            $document = Document::create();

            $uploadPath = "/uploads/documents/{$document->id}/";
            $fileName = md5($pdf->getFilename()) . '.pdf';

            $pdf->move(public_path($uploadPath), $fileName);
            $document->update(['path' => $uploadPath . $fileName]);

            return $this->json(compact('document'), null, 201);
        }

        return $this->json(null, ['No Document found'], 422);
    }
}
