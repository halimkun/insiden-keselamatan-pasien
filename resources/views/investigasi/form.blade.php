<div class="space-y-6">

    <div>
        <x-input-label for="penyebab_langsung" :value="__('Penyebab Langsung')" />
        <textarea id="penyebab_langsung" name="penyebab_langsung" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3" autocomplete="penyebab_langsung" placeholder="Penyebab langsung insiden">{{ old('penyebab_langsung', $investigasi?->penyebab_langsung) }}</textarea>
        <x-input-error class="" :messages="$errors->get('penyebab_langsung')" />
    </div>

    <div>
        <x-input-label for="penyebab_awal" :value="__('Penyebab Awal')" />
        <textarea id="penyebab_awal" name="penyebab_awal" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3" autocomplete="penyebab_awal" placeholder="Penyebab awal insiden">{{ old('penyebab_awal', $investigasi?->penyebab_awal) }}</textarea>
        <x-input-error class="" :messages="$errors->get('penyebab_awal')" />
    </div>

    <x-separator text="rekomendasi" color="text-gray-500 my-1" />
    
    @foreach (['pendek', 'menengah', 'panjang'] as $item)
        <div class="flex gap-6">
            <div class="w-full flex-1">
                <x-input-label for="rekomendasi_{{ $item }}" class="capitalize" :value="'Rekomandasi Jangka ' . $item" />
                <textarea id="rekomendasi_{{ $item }}" name="rekomendasi_{{ $item }}" 
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 resize-y overflow-hidden min-h-[120px]" 
                    autocomplete="rekomendasi_{{ $item }}" 
                    placeholder="Rekomendasi investigasi jangka {{ $item }}"
                >{{ old('rekomendasi_' . $item, $investigasi?->rekomendasi?->where('jangka_waktu', $item)->first()?->rekomendasi) }}</textarea>
                <x-input-error class="" :messages="$errors->get('rekomendasi_' . $item)" />
            </div>
            
            <div class="flex flex-col gap-3 w-[40%]">
                <div class="w-full">
                    <x-input-label for="batas_waktu_{{ $item }}" class="capitalize text-sm" :value="'Batas Waktu'" />
                    <x-text-input id="batas_waktu_{{ $item }}" name="batas_waktu_{{ $item }}" type="date" class="mt-1 block w-full"
                        :value="old('batas_waktu_' . $item, $investigasi?->rekomendasi?->where('jangka_waktu', $item)->first()?->batas_waktu)" autocomplete="batas_waktu_{{ $item }}"
                        placeholder="batas waktu rekomendasi jangka {{ $item }}" />
                    <x-input-error class="" :messages="$errors->get('batas_waktu_' . $item)" />
                </div>

                <div class="w-full">
                    <x-input-label for="pj_{{ $item }}" class="capitalize" :value="'Penanggung Jawab'" />
                    <select id="pj_{{ $item }}" name="pj_{{ $item }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Penanggung Jawab Jangka {{ $item }} --</option>
                        @foreach ($karyawan as $karyawanItem)
                            <option value="{{ $karyawanItem->id }}" 
                                {{ old('pj_' . $item, $investigasi?->rekomendasi?->where('jangka_waktu', $item)->first()?->pj) == $karyawanItem->id ? 'selected' : '' }}>
                                {{ $karyawanItem->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('pj_' . $item)" />
                </div>                
            </div>
        </div>
    @endforeach

    <x-separator text="Pengesahan" color="text-gray-500 my-1" />

    <div class="flex gap-3">
        <div class="w-full">
            <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
            <x-text-input id="tanggal_mulai" name="tanggal_mulai" type="date" class="mt-1 block w-full"
                :value="old('tanggal_mulai', $investigasi?->tanggal_mulai)" autocomplete="tanggal_mulai"
                placeholder="Tanggal Mulai" />
            <x-input-error class="" :messages="$errors->get('tanggal_mulai')" />
        </div>
    
        <div class="w-full">
            <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
            <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date" class="mt-1 block w-full"
                :value="old('tanggal_selesai', $investigasi?->tanggal_selesai)" autocomplete="tanggal_selesai"
                placeholder="Tanggal Selesai" />
            <x-input-error class="" :messages="$errors->get('tanggal_selesai')" />
        </div>
    </div>

    <div>
        <x-input-label for="tanggal_pengesahan" :value="__('Tanggal Pengesahan')" />
        <x-text-input id="tanggal_pengesahan" name="tanggal_pengesahan" type="date" class="mt-1 block w-full"
            :value="old('tanggal_pengesahan', $investigasi?->tanggal_pengesahan)" autocomplete="tanggal_pengesahan"
            placeholder="Tanggal Pengesahan" />
        <x-input-error class="" :messages="$errors->get('tanggal_pengesahan')" />
    </div>

    <div>
        <x-input-label for="lengkap" value="Investigasi Lengkap" />
        <div class="mt-1 grid grid-cols-2 items-center gap-3">
            @foreach ([
                '1' => 'Ya Lengkap',
                '0' => 'Belum Lengkap',
            ] as $value => $label)
                <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                    <label class="label cursor-pointer items-center justify-start gap-2">
                        <input type="radio" value="{{ $value }}" {{ old('lengkap', $investigasi?->lengkap) == $value ? 'checked' : '' }} name="lengkap" class="radio radio-xs checked:bg-red-500" />
                        <span class="label-text">{{ $label }}</span>
                    </label>
                </div>
            @endforeach
        </div>
        <x-input-error class="" :messages="$errors->get('lengkap')" />
    </div>

    <div>
        <x-input-label for="lanjutan" value="Butuh Investigasi Lanjutan" />
        <div class="mt-1 grid grid-cols-2 items-center gap-3">
            @foreach ([
                '1' => 'Ya Diperlukan',
                '0' => 'Tidak Diperlukan',
            ] as $value => $label)
                <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                    <label class="label cursor-pointer items-center justify-start gap-2">
                        <input type="radio" value="{{ $value }}" {{ old('lanjutan', $investigasi?->lanjutan) == $value ? 'checked' : '' }} name="lanjutan" class="radio radio-xs checked:bg-red-500" />
                        <span class="label-text">{{ $label }}</span>
                    </label>
                </div>
            @endforeach
        </div>
        <x-input-error class="" :messages="$errors->get('lanjutan')" />
    </div>

    <div class="w-full space-y-5">
        <div>
            <x-input-label for="grading_risiko" value="Grading Setelah Investigasi" />
            <div class="mt-1 grid grid-cols-2 gap-3 lg:grid-cols-4">
                {{-- form grading ikp : Biru, Hijau, Kuning, Merah --}}
                <div class="form-control rounded-lg border border-gray-200 bg-sky-500 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-sky-600">
                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="radio" value="biru" {{ \Str::lower(old('grading', $investigasi?->grading?->grading_risiko)) == 'biru' ? 'checked' : '' }} name="grading" class="radio radio-xs checked:bg-sky-500" />
                        <span class="label-text font-medium text-white">Biru</span>
                    </label>
                </div>

                <div class="form-control rounded-lg border border-gray-200 bg-emerald-500 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-emerald-600">
                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="radio" value="hijau" {{ \Str::lower(old('grading', $investigasi?->grading?->grading_risiko)) == 'hijau' ? 'checked' : '' }} name="grading" class="radio radio-xs checked:bg-emerald-500" />
                        <span class="label-text font-medium text-white">Hijau</span>
                    </label>
                </div>

                <div class="form-control rounded-lg border border-gray-200 bg-amber-500 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-amber-600">
                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="radio" value="kuning" {{ \Str::lower(old('grading', $investigasi?->grading?->grading_risiko)) == 'kuning' ? 'checked' : '' }} name="grading" class="radio radio-xs checked:bg-amber-500" />
                        <span class="label-text font-medium text-white">Kuning</span>
                    </label>
                </div>

                <div class="form-control rounded-lg border border-gray-200 bg-rose-500 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-rose-600">
                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="radio" value="merah" {{ \Str::lower(old('grading', $investigasi?->grading?->grading_risiko)) == 'merah' ? 'checked' : '' }} name="grading" class="radio radio-xs checked:bg-rose-500" />
                        <span class="label-text font-medium text-white">Merah</span>
                    </label>
                </div>
            </div>
            <x-input-error class="" :messages="$errors->get('grading')" />
        </div>
    </div>
</div>