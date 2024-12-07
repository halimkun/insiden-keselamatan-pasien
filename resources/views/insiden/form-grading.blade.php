<div class="space-y-6">

    <div class="w-full">
        <x-input-label for="grading_risiko" value="Grading" />
        <div class="mt-1 grid grid-cols-2 gap-3 lg:grid-cols-4">
            {{-- form grading ikp : Biru, Hijau, Kuning, Merah --}}
            <div class="form-control rounded-lg border border-gray-200 bg-sky-500 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-sky-600">
                <label class="label cursor-pointer justify-start gap-2">
                    <input type="radio" value="biru" {{ \Str::lower(old('grading_risiko', $insiden?->grading_risiko)) == 'biru' ? 'checked' : '' }} name="grading_risiko" class="radio radio-xs checked:bg-sky-500" />
                    <span class="label-text font-medium text-white">Biru</span>
                </label>
            </div>

            <div class="form-control rounded-lg border border-gray-200 bg-emerald-500 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-emerald-600">
                <label class="label cursor-pointer justify-start gap-2">
                    <input type="radio" value="hijau" {{ \Str::lower(old('grading_risiko', $insiden?->grading_risiko)) == 'hijau' ? 'checked' : '' }} name="grading_risiko" class="radio radio-xs checked:bg-emerald-500" />
                    <span class="label-text font-medium text-white">Hijau</span>
                </label>
            </div>

            <div class="form-control rounded-lg border border-gray-200 bg-amber-500 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-amber-600">
                <label class="label cursor-pointer justify-start gap-2">
                    <input type="radio" value="kuning" {{ \Str::lower(old('grading_risiko', $insiden?->grading_risiko)) == 'kuning' ? 'checked' : '' }} name="grading_risiko" class="radio radio-xs checked:bg-amber-500" />
                    <span class="label-text font-medium text-white">Kuning</span>
                </label>
            </div>

            <div class="form-control rounded-lg border border-gray-200 bg-rose-500 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-rose-600">
                <label class="label cursor-pointer justify-start gap-2">
                    <input type="radio" value="merah" {{ \Str::lower(old('grading_risiko', $insiden?->grading_risiko)) == 'merah' ? 'checked' : '' }} name="grading_risiko" class="radio radio-xs checked:bg-rose-500" />
                    <span class="label-text font-medium text-white">Merah</span>
                </label>
            </div>
        </div>

        <x-input-error class="mt-2" :messages="$errors->get('grading_risiko')" />
    </div>
    
</div>
