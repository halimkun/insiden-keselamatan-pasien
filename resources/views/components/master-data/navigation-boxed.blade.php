<div role="tablist" class="tabs-boxed tabs gap-1">
    <a 
        role="tab" 
        href="{{ route('unit.index') }}" 
        class="{{ request()->routeIs('unit.index') ? 'tab-active' : '' }} group tab font-semibold transition-all duration-300 ease-in-out hover:bg-indigo-200">
        Unit
    </a>
    <a 
        role="tab" 
        href="{{ route('jenis-insiden.index') }}" 
        class="{{ request()->routeIs('jenis-insiden.index') ? 'tab-active' : '' }} group tab font-semibold transition-all duration-300 ease-in-out hover:bg-indigo-200">
        Jenis Insiden
    </a>
    <a 
        role="tab" 
        href="{{ route('penanggung-biaya.index') }}" 
        class="{{ request()->routeIs('penanggung-biaya.index') ? 'tab-active' : '' }} group tab font-semibold transition-all duration-300 ease-in-out hover:bg-indigo-200">
        Penanggung Biaya
    </a>
</div>
