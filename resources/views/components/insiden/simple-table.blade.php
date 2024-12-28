<div class="overflow-x-auto">
    <table class="table table-full w-full">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No. </th>
                <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Insiden</th>
                <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Jenis</th>
                <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tgl Kejadian</th>
                <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Dampak</th>
                <th class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tempat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($insiden as $item)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 pl-4 pr-3 text-left text-gray-500 capitalize">{{ $loop->iteration }}.</td>
                    <td class="py-3 pl-4 pr-3 text-left text-gray-500 capitalize">{{ $item->insiden }}</td>
                    <td class="py-3 pl-4 pr-3 text-left text-gray-500 capitalize">{{ $item->jenis->alias }}</td>
                    <td class="py-3 pl-4 pr-3 text-left text-gray-500 capitalize">
                        <p>{{ $item->tanggal_insiden->translatedFormat('l, d F Y') }}</p>
                        <p>{{ $item->waktu_insiden }}</p>
                    </td>
                    <td class="py-3 pl-4 pr-3 text-left text-gray-500 capitalize">{{ $item->dampak_insiden }}</td>
                    <td class="py-3 pl-4 pr-3 text-left text-gray-500 capitalize">
                        <p>{{ $item->tempat_kejadian }}</p>
                        <p><span class="font-bold">Unit : </span>{{ $item->unit->nama_unit }}</p>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>