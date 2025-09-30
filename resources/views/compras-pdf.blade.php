<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Relatório de Compras</title>
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
    <h1>Relatório de Compras</h1>
    <h2>Comprador: {{ $loggedUser->name }}</h2>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Valor</th>
                <th>Produto</th>
                <th>Categoria do Produto</th>
                <th>Vendedor</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse ($compras as $compra)
                @php
                    $grandTotal += $compra->total_amount;
                @endphp
                <tr>
                    {{-- Usamos as variáveis do objeto $compra --}}
                    <td>{{ $compra->created_at->format('d/m/Y') }}</td>
                    <td>R$ {{ number_format($compra->total_amount, 2, ',', '.') }}</td>
                    <td>{{ $compra->product->name ?? 'N/A' }}</td>
                    <td>{{ $compra->product->category->category_name ?? 'N/A' }}</td>
                    <td>{{ $compra->seller->name ?? 'N/A' }}</td>
                </tr>
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

