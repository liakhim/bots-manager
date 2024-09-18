<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function view(Request $request): Response
    {
        $data = ['title' => 'Пример PDF файла'];
        $pdf = PDF::loadView('pdf_view', $data);

        return $pdf->stream('example.pdf');
    }
}
