<?php $field['value'] = isset($field['value']) ? $field['value'] : ''; ?>

<fieldset class="form-group">
    <label for="datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}-{{ $field['id'] }}">{{ $field['name'] }}</label>
    <select class="form-control datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}" id="datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}-{{ $field['id'] }}" name="{{ $field['id'] }}">
        <option value="">Tous</option>

        @foreach(['1' => 'Oui', '0' => 'Non'] as $value => $name)
            <option value="{{ $value }}" {{{ $value === $field['value'] ? 'selected="selected"' : '' }}}>{{ $name }}</option>
        @endforeach
    </select>
</fieldset>