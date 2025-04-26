<div class="tab-viajero-box">
    <div class="tab-viajero-select">
        <div class="tab-viajero-text">
            <span class="viajero-text">Viajero #1</span>
        </div>
        <div class="tab-viajero-icon">
            <div class="ge">
                <i class="fa-solid fa-chevron-down" style="font-size: 14px;"></i>
            </div>
        </div>
    </div>

    <div class="tab-viajero-form hidden">
        @foreach ($formulario->variables as $variable)
            @if ($variable->tipo_variable === 'VIAJERO')
                @if ($variable->tipo_elemento === 'DATE_PICKER')
                    @include('ui.DatePicker')
                @endif
                @if ($variable->tipo_elemento === 'INPUT_TEXT' || $variable->tipo_elemento === 'INPUT_NUMBER')
                    @include('ui.Input')
                @endif
                @if ($variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE')
                    @include('ui.Checkbox')
                @endif
                @if ($variable->tipo_elemento === 'SELECT')
                        @include('ui.Select')
                    @endif
            @endif
        @endforeach
    </div>
</div>