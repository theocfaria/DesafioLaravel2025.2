<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoricoVendaController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $user = Auth::user();
        $query = Sale::query();

        if ($user->function->function_name == 'Administrador') {
            $query->with(['buyer', 'products.seller', 'products.category']);
        } else {
            $query->whereHas('products', function ($q) use ($user) {
                $q->where('seller_id', $user->user_id);
            })->with(['buyer', 'products.seller', 'products.category']);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:59']);
        }

        $sales = $query->latest()->paginate(10);

        return view('historico-venda', compact('sales'));
    }

    public function generatePdf(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $user = Auth::user();

        $query = Sale::query();

        if ($user->function->function_name == 'Administrador') {
            $query->with(['buyer', 'products.seller', 'products.category']);
        } else {
            $query->whereHas('products', function ($q) use ($user) {
                $q->where('seller_id', $user->user_id);
            })->with(['buyer', 'products.seller', 'products.category']);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:59']);
        }

        $sales = $query->latest()->get();
        $loggedUser = $user;

        $pdf = Pdf::loadView('pdf', compact('sales', 'loggedUser'));

        return $pdf->stream('relatorio_vendas.pdf');
    }
}