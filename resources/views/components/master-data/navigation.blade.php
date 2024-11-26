<div role="tablist" class="tabs tabs-bordered tabs-sm">
    <a href="{{ route('jenis-insiden.index') }}" role="tab" class="{{ request()->routeIs('jenis-insiden.index') ? 'tab-active' : '' }} tab">Jenis Insiden</a>
    <a href="{{ route('penanggung-biaya.index') }}" role="tab" class="{{ request()->routeIs('penanggung-biaya.index') ? 'tab-active' : '' }} tab">Penanggung Biaya</a>
    <a href="{{ route('unit.index') }}" role="tab" class="{{ request()->routeIs('unit.index') ? 'tab-active' : '' }} tab">Unit</a>
</div>
