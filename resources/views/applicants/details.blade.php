@include('components.header')

<div class="max-w-4xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6">Resumo por Semestre - {{ $instrument }}</h2>

    <table class="min-w-full bg-white border border-gray-200 text-sm text-gray-700 mb-6">
        <thead class="bg-gray-100 text-left">
        <tr>
            <th class="py-2 px-4 border-b">Semestre</th>
            <th class="py-2 px-4 border-b text-center">Total</th>
            <th class="py-2 px-4 border-b text-center">Aprovados</th>
            <th class="py-2 px-4 border-b text-center">Taxa de Aprovação (%)</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $item)
            <tr class="hover:bg-gray-50">
                <td class="py-2 px-4 border-b">{{ $item->semester }}</td>
                <td class="py-2 px-4 border-b text-center">{{ $item->total }}</td>
                <td class="py-2 px-4 border-b text-center">{{ $item->aprovados }}</td>
                <td class="py-2 px-4 border-b text-center">{{ number_format($item->porcentagem, 2) }}%</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@include('components.scripts')
