<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoricoCompraController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $user = Auth::user();

        $query = Order::where('buyer_id', $user->user_id)
                      ->with(['seller', 'product.category']); 

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:59']);
        }

        $compras = $query->latest()->paginate(10);

        return view('historico-compras', compact('compras'));
    }

    public function generatePdf(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $user = Auth::user();

        $query = Order::where('buyer_id', $user->user_id)
                      ->with(['seller', 'product.category']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:59']);
        }

        $compras = $query->latest()->get();
        $loggedUser = $user;

        $pdf = Pdf::loadView('compras-pdf', compact('compras', 'loggedUser'));

        return $pdf->stream('relatorio_compras.pdf');
    }
}