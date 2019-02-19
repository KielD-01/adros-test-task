<?php

namespace App\Observers;

use App\Models\Document;
use Exception;
use Illuminate\Support\Facades\Log;
use Imagick;
use Spatie\PdfToImage\Exceptions\InvalidFormat;
use Spatie\PdfToImage\Exceptions\PageDoesNotExist;
use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
use Spatie\PdfToImage\Pdf;

class DocumentObserver
{

    /**
     * Handle the document "updated" event.
     *
     * @param  \App\Models\Document $document
     * @return void
     */
    public function updated(Document $document)
    {
        if (extension_loaded('imagick')) {
            try {
                $thumbnailPath = "/uploads/documents/{$document->id}/";

                ini_set('max_execution_time', 300); // Because of the Imagick

                $pdf = new Imagick();
                $pdf->readImage(public_path($document->path) . "[0]");
                $pdf->setImageResolution(144, 256);

                if ($pdf->writeImage(public_path($thumbnailPath) . 'thumbnail.webp')) {
                    $document->update(['thumbnail' => "{$thumbnailPath}thumbnail.webp"]);
                }
            } catch (Exception $exception) {
                Log::error($exception);
            }
        }
    }

    /**
     * Handle the document "deleted" event.
     *
     * @param  \App\Models\Document $document
     * @return void
     */
    public function deleted(Document $document)
    {
        try {
            unlink(public_path($document->path));
            rmdir(public_path("/uploads/documents/{$document->id}/"));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

}
