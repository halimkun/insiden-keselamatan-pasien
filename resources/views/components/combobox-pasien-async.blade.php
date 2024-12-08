@props(['rm' => null, 'openResults' => false])

<div x-data="combobox()" class="w-full">
    <div class="relative mt-1">
        <input id="combobox" type="text" autocomplete="off" role="combobox" 
            class="w-full rounded-md border-0 bg-white py-2 pl-3 pr-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            aria-controls="options" 
            aria-expanded="false" 
            placeholder="cari pasien" 
            x-model="query"
            
            @input.debounce.500ms="fetchData" 
            @keydown.arrow-up.prevent="moveUp" 
            @keydown.arrow-down.prevent="moveDown"
            @keydown.enter.prevent="selectHighlighted">
        <button type="button" class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
            <x-icons.caret-up-down class="h-5 w-5 text-gray-400" />
        </button>

        <ul class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" id="options" role="listbox" x-show="openResults">
            {{-- if state pending --}}
            <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900 group" x-show="status === 'pending'">
                <div class="flex items-center">
                    <div class="ml-1 w-full">
                        <span class="truncate font-medium">Loading...</span>
                    </div>
                </div>
            </li>

            {{-- if state error --}}
            <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900 group" x-show="status === 'error'">
                <div class="flex items-center">
                    <div class="ml-1 w-full">
                        <span class="truncate font-medium">Error fetching data</span>
                    </div>
                </div>
            </li>

            {{-- if state success --}}
            <template x-if="status === 'success'">
                <template x-for="(result, index) in results" :key="index">
                    <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900 group hover:bg-indigo-500 hover:text-white" :class="{ 'bg-indigo-500 text-white': highlightedIndex === index }" :id="'option-' + index" role="option" tabindex="-1" @click="selectResult(result)">
                        <div class="flex items-center">
                            <div class="ml-1 w-full">
                                <span class="truncate font-medium" x-text="result.name"></span>
                                <div class="flex justify-between items-center w-[calc(100%-0.7rem)]">
                                    <span class="block text-sm group-hover:text-gray-300"
                                        :class="{ 'text-gray-500': highlightedIndex !== index, 'text-gray-300': highlightedIndex === index }"
                                        x-text="result.gender == 'L' ? 'Laki-laki' : 'Perempuan'">
                                    </span>
                                    <span class="block text-sm group-hover:text-gray-300"
                                        :class="{ 'text-gray-500': highlightedIndex !== index, 'text-gray-300': highlightedIndex === index }"
                                        x-text="result.dob">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 group-hover:text-gray-300 transition-colors" :class="{ 'text-indigo-600': isSelected(result) }" x-show="isSelected(result)">
                            <x-icons.check class="h-5 w-5" />
                        </span>
                    </li>
                </template>
            </template>

            <li class="relative cursor-pointer select-none py-2 pl-3 pr-9 text-gray-900 group hover:bg-indigo-500 hover:text-white" role="option" tabindex="-1" @click="handleUrl('tambah')" x-show="status != 'pending' && status !== 'error'">
                <div class="flex items-center">
                    <x-icons.circle-plus class="h-5 w-5 text-gray-500 group-hover:text-white" />
                    <div class="ml-1 w-full">
                        <span class="truncate font-medium">Tambah Pasien</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

<script>
    function handleUrl(rm) {
        const url = new URL(window.location.href);
        
        if (rm === 'tambah') {
            url.searchParams.set('act', 'tambah');
            url.searchParams.delete('pasien');
        } else {
            url.searchParams.set('pasien', btoa(btoa(rm)));
            url.searchParams.delete('act');
        }

        url.searchParams.set('step', 2);

        window.history.replaceState({}, '', url);
        window.dispatchEvent(new Event('popstate'));
        window.location.reload();
    }

    function combobox() {
        return {
            results: [],
            status: 'idle',
            openResults: @json($openResults),
            selectedResult: null, // Data item yang dipilih
            highlightedIndex: -1, // Index dari item yang disorot dengan keyboard
            query: @json($rm ?? ''),
            fetchData() {
                this.status = 'pending';
                this.openResults = true;

                if (this.query.trim() === '') {
                    this.openResults = false;
                    this.results = [];
                    this.highlightedIndex = -1;
                    this.status = 'idle';
                    return;
                }

                setTimeout(() => {
                    fetch(`http://127.0.0.1:8000/api/pasien/search?keyword=${this.query}`)
                        .then(response => response.json())
                        .then(data => {
                            this.results = data.map(item => ({
                                id: item.id, // Tambahkan ID unik untuk membedakan item
                                name: item.nama || 'undefined',
                                dob: item.tanggal_lahir !== null ? new Date(item.tanggal_lahir).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : 'undefined',
                                gender: item.jenis_kelamin || 'undefined',
                                no_rekam_medis: item.no_rekam_medis || 'undefined',
                            }));

                            this.status = 'success';
                            this.highlightedIndex = -1; // Reset index item yang disorot
                        })
                        .catch(err => {
                            console.error('Error fetching data:', err);
                            this.status = 'error';
                            this.results = [];
                        });
                }, 1000);
            },
            moveDown() {
                if (this.results.length === 0) return;
                this.highlightedIndex =  (this.highlightedIndex + 1) % this.results.length; // Loop ke awal jika di akhir

                this.scrollToHighlighted();
            },
            moveUp() {
                if (this.results.length === 0) return;
                this.highlightedIndex = (this.highlightedIndex - 1 + this.results.length) % this.results.length; // Loop ke akhir jika di awal

                this.scrollToHighlighted();
            },
            selectHighlighted() {
                if (this.highlightedIndex >= 0) {
                    this.selectResult(this.results[this.highlightedIndex]);
                }
            },
            scrollToHighlighted() {
                const highlighted = document.getElementById(`option-${this.highlightedIndex}`);
                if (highlighted) {
                    highlighted.scrollIntoView({
                        block: 'nearest', // Pastikan elemen terlihat tanpa menggulir seluruh container
                    });
                }
            },
            selectResult(result) {
                handleUrl(result.no_rekam_medis);
                
                this.openResults = false;
                this.selectedResult = result; // Simpan item yang dipilih
                this.query = result.no_rekam_medis; // Set nama yang dipilih ke input field
                this.results = []; // Kosongkan dropdown setelah memilih
                this.status = 'idle';
            },
            isSelected(result) {
                // Periksa apakah item ini adalah item yang dipilih
                return this.selectedResult && this.selectedResult.id === result.id;
            },
        };
    }
</script>