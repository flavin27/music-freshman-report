<div class="flex flex-col min-h-screen">
    @include('components.header')

    <!-- conteúdo principal -->
    <main class="flex-grow">
        <div class="max-w-4xl mx-auto mt-10">
            <div class="flex items-center justify-between mb-6">
                <!-- Título -->
                <h2 class="text-2xl font-bold">Relatório por Instrumento</h2>

                <!-- Campo de busca pequeno -->
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Buscar..."
                    class="p-2 border rounded text-sm w-40"
                >
            </div>

            <div class="overflow-x-auto rounded-lg shadow">
                <table id="sortableTable" class="min-w-full bg-white border border-gray-200 text-sm text-gray-700">
                    <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="py-3 px-4 border-b">Instrumento</th>
                        <th class="py-3 px-4 border-b text-center">Total</th>
                        <th class="py-3 px-4 border-b text-center">Aprovados</th>
                        <th class="py-3 px-4 border-b text-center">Taxa de Aprovação</th>
                    </tr>
                    </thead>
                    <tbody id="tableBody">
                    @foreach ($data as $item)
                        <tr class="hover:bg-gray-50 cursor-pointer"
                            onclick="window.location='{{ route('applicants.details', ['instrument' => $item->instrument]) }}'">
                            <td class="py-2 px-4 border-b">{{ $item->instrument }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $item->total }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $item->aprovados }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ number_format($item->porcentagem, 2) }}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    @include('components.footer')
</div>

@include('components.scripts')
