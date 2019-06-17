<?php $field['value'] = isset($field['value']) ? $field['value'] : ''; ?>

<fieldset class="form-group">
    <label for="datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}-{{ $field['id'] }}">{{ $field['name'] }}</label>
    <select class="form-control datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }} {{ isset($field['extra']) && isset($field['extra']['select2']) ? 'select2-search' : '' }}" {{ isset($field['extra']) && isset($field['extra']['multiple']) ? 'multiple' : '' }} id="datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}-{{ $field['id'] }}" name="{{ $field['id'] }}[]">
        @if(isset($field['extra']) && isset($field['extra']['multiple']))
        @else
            <option value="">Tous</option>
        @endif

        @foreach($field['field'] as $value => $name)
            <option value="{{ $value }}" {{{ $value == $field['value'] ? 'selected="selected"' : '' }}}>{{ $name }}</option>
        @endforeach
    </select>
</fieldset>