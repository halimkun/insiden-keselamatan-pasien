<div class="space-y-6">

    <div>
        <x-input-label for="tindakan" value="Tindakan" />
        <textarea id="tindakan" name="tindakan" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3" autocomplete="tindakan" placeholder="Detail tindakan pasca insiden dan hasilnya">{{ old('tindakan', $insiden?->tindakan?->deskripsi_tindakan) }}</textarea>

        <x-input-error class="mt-2" :messages="$errors->get('tindakan')" />
    </div>

    <div>
        <x-input-label for="oleh" value="Tindakan Dilakukan Oleh" />
        <div class="mt-1 grid grid-cols-2 gap-3">
            <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                <label class="label cursor-pointer justify-start gap-2">
                    <input type="radio" value="dokter" {{ old('oleh', $insiden?->tindakan?->oleh) == 'dokter' ? 'checked' : '' }} name="oleh" class="radio radio-xs checked:bg-red-500" />
                    <span class="label-text">Dokter</span>
                </label>
            </div>

            <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                <label class="label cursor-pointer justify-start gap-2">
                    <input type="radio" value="perawat" {{ old('oleh', $insiden?->tindakan?->oleh) == 'perawat' ? 'checked' : '' }} name="oleh" class="radio radio-xs checked:bg-red-500" />
                    <span class="label-text">Perawat</span>
                </label>
            </div>

            <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                <label class="label cursor-pointer justify-start gap-2 p-0.5 m-0">
                    <input type="radio" value="tim" {{ old('oleh', $insiden?->tindakan?->oleh) == 'tim' ? 'checked' : '' }} name="oleh" class="radio radio-xs checked:bg-red-500" />
                    Tim <x-text-input id="oleh_tim" name="oleh_tim" type="text" class="input-sm w-full" :value="old('oleh_tim', $insiden?->tindakan?->oleh_tim)" autocomplete="oleh_tim" placeholder="Tim Terdiri dari" />
                </label>
                <x-input-error class="mt-1 ml-6" :messages="$errors->get('oleh_tim')" />
            </div>

            <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                <label class="label cursor-pointer justify-start gap-2 p-0.5 m-0">
                    <input type="radio" value="petugas" {{ old('oleh', $insiden?->tindakan?->oleh) == 'petugas' ? 'checked' : '' }} name="oleh" class="radio radio-xs checked:bg-red-500" />
                    <x-text-input id="oleh_petugas" name="oleh_petugas" type="text" class="input-sm w-full" :value="old('oleh_petugas', $insiden?->tindakan?->oleh_petugas)" autocomplete="oleh_petugas" placeholder="Petugas Lainnya" />
                </label>
                <x-input-error class="mt-1 ml-6" :messages="$errors->get('oleh_petugas')" />
            </div>
        </div>

        <x-input-error class="mt-2" :messages="$errors->get('oleh')" />
    </div>

    <div class="w-full">
        <x-input-label for="status_pelapor" value="Status Pelapor" />
        <select id="status_pelapor" name="status_pelapor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value=""></option>
            @foreach ([
                "Penemu Insiden",
                "Terlibat Langsung",
            ] as $status_pelapor)
                <option value="{{ $status_pelapor }}" {{ old('status_pelapor', $insiden?->status_pelapor) == $status_pelapor ? 'selected' : '' }}>{{ $status_pelapor }}</option>
            @endforeach
        </select>

        <x-input-error class="mt-2" :messages="$errors->get('status_pelapor')" />
    </div>

    <div>
        <x-input-label for="pernah_terjadi" value="Apakah kejadian yang sama pernah terjadi di Unit Kerja lain?" />
        <div class="mt-1 grid grid-cols-2 gap-3">
            <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                <label class="label cursor-pointer justify-start gap-2">
                    <input type="radio" value="1" {{ old('pernah_terjadi', $insiden?->pernah_terjadi) == '1' ? 'checked' : '' }} name="pernah_terjadi" class="radio radio-xs checked:bg-red-500" />
                    <span class="label-text">Ya</span>
                </label>
            </div>
            <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                <label class="label cursor-pointer justify-start gap-2">
                    <input type="radio" value="0" {{ old('pernah_terjadi', $insiden?->pernah_terjadi) == '0' ? 'checked' : '' }} name="pernah_terjadi" class="radio radio-xs checked:bg-red-500" />
                    <span class="label-text">Tidak</span>
                </label>
            </div>
        </div>

        <x-input-error class="mt-2" :messages="$errors->get('pernah_terjadi')" />
    </div>
</div>
