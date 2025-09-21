<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Relatório de Vendas</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 40px;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 16px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Relatório de Vendas</h1>
    <h2>Vendedor: {{ $loggedUser->name }}</h2>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Valor</th>
                <th>Categoria do Produto</th>
                <th>Comprador</th>
                <th>Vendedor</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse ($sales as $sale)
                @foreach ($sale->products as $product)
                    @php
                        $itemValue = $product->pivot->price_at_sale * $product->pivot->quantity;
                        $grandTotal += $itemValue;
                    @endphp
                    <tr>
                        <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                        <td>R$ {{ number_format($itemValue, 2, ',', '.') }}</td>
                        <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                        <td>{{ $sale->buyer->name }}</td>
                        <td>{{ $product->seller->name }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Nenhum registro encontrado para o período.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td class="total" colspan="1">Total Geral</td>
                <td class="total" colspan="4">R$ {{ number_format($grandTotal, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>