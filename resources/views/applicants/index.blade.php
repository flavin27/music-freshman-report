@include('components.header')

<div class="max-w-4xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6">Relatório por Instrumento</h2>

    <div class="overflow-x-auto rounded-lg shadow">
        <table id="sortableTable" class="min-w-full bg-white border border-gray-200 text-sm text-gray-700 ">
            <thead class="bg-gray-100 text-left">
            <tr class="cursor-pointer">
                <th class="py-3 px-4 border-b">Instrumento</th>
                <th class="py-3 px-4 border-b text-center">Total</th>
                <th class="py-3 px-4 border-b text-center">Aprovados</th>
                <th class="py-3 px-4 border-b text-center">Taxa de Aprovação</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $item)
                <tr
                    class="hover:bg-gray-50 cursor-pointer"
                    onclick="window.location='{{ route('applicants.details', ['instrument' => $item->instrument]) }}'"
                >
                    <td class="py-2 px-4 border-b">{{ $item->instrument }}</td>
                    <td class="py-2 px-4 border-b text-center" data-sort="{{$item->total/100}}">{{ $item->total }}</td>
                    <td class="py-2 px-4 border-b text-center" data-sort="{{$item->aprovados/100}}">{{ $item->aprovados }}</td>
                    @if($item->porcentagem == 0)
                        <td class="py-2 px-4 border-b text-center text-red-500"  data-sort="{{ $item->aprovados / $item->total }}">
                            {{ number_format($item->porcentagem, 2) }}%
                        </td>
                    @endif
                    @if($item->porcentagem > 0 && $item->porcentagem < 100)
                        <td class="py-2 px-4 border-b text-center"  data-sort="{{ $item->aprovados / $item->total }}">
                            {{ number_format($item->porcentagem, 2) }}%
                        </td>
                    @endif
                    @if($item->porcentagem == 100)
                        <td class="py-2 px-4 border-b text-center text-green-500"  data-sort="{{ $item->aprovados / $item->total }}">
                            {{ number_format($item->porcentagem, 2) }}%
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
</div>
@include('components.footer')
@include('components.scripts')
