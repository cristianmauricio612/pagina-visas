@foreach ($formulario->variables as $variable)
    @if ($variable->tipo_variable === 'PASAPORTE')
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