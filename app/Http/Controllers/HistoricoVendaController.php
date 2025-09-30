<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;


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

        $chartQuery = Sale::query()->where('created_at', '>=', now()->subMonths(12));

        if ($user->function->function_name != 'Administrador') {
            $chartQuery->whereHas('products', function ($q) use ($user) {
                $q->where('seller_id', $user->user_id);
            });
        }

        $chart_options = [
            'chart_title' => 'Vendas realizadas por mês',
            'model' => Sale::class,
            'chart_type' => 'line',
            'report_type' => 'group_by_relationship',
            'relationship_name' => 'seller',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_color' => '37, 99, 235',

            'query' => $chartQuery,
        ];

        $chart = new LaravelChart($chart_options);

        return view('historico-venda', compact('sales', 'chart'));
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