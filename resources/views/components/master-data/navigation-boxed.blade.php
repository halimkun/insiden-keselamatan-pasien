<div role="tablist" class="tabs tabs-boxed gap-1">
    <a href="{{ route('unit.index') }}" role="tab" class="tab hover:bg-indigo-200 transition-all duration-300 ease-in-out group {{ request()->routeIs('unit.index') ? 'tab-active' : '' }}">Unit</a>
    <a href="{{ route('jenis-insiden.index') }}" role="tab" class="tab hover:bg-indigo-200 transition-all duration-300 ease-in-out group {{ request()->routeIs('jenis-insiden.index') ? 'tab-active' : '' }}">Jenis Insiden</a>
    <a href="{{ route('penanggung-biaya.index') }}" role="tab" class="tab hover:bg-indigo-200 transition-all duration-300 ease-in-out group {{ request()->routeIs('penanggung-biaya.index') ? 'tab-active' : '' }}">Penanggung Biaya</a>
</div>