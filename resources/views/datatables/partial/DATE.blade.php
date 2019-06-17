<fieldset class="form-group">
    <label for="datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}-{{ $field['id'] }}">{{ $field['name'] }}</label>
    <input type="text" class="form-control datepicker datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}" id="datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}-{{ $field['id'] }}" value="{{ isset($field['value']) ? $field['value'] : '' }}" name="{{ $field['id'] }}">
</fieldset>