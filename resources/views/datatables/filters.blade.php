<?php $entity = new $entity(); ?>

<form id="datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}" class="mb-4 filters">
    <div class="row">
        @foreach($entity->datatables()->getSearches() as $field)
            <div class="col-12 col-md-{{ isset($columnSize) ? $columnSize : 2 }}">
                @if(is_array($field['field']))
                    @include('datatables.partial.ARRAY', ['entity' => $entity, 'search' => $field])
                @else
                    @include('datatables.partial.' . $field['field'], ['entity' => $entity, 'search' => $field])
                @endif
            </div>
        @endforeach
    </div>
</form>

@section('footer.js')
    @parent
    <script type="text/javascript">
        var wrapper = {{{ $entity->datatables()->getJavascriptWrapperName() }}} = function () {
            var self = this;

            self.queue = {};
            self.fired = [];

            return {
                fire: function (event) {
                    var queue = self.queue[event];
                    if (typeof queue === 'undefined') {
                        return;
                    }

                    for (var i = 0; i < queue.length; i++) {
                        queue[i]();
                    }

                    self.fired[event] = true;
                },
                on: function (event, callback) {
                    if (self.fired[event] === true) {
                        return callback();
                    }

                    if (typeof self.queue[event] === 'undefined') {
                        self.queue[event] = [];
                    }

                    self.queue[event].push(callback);
                },
                get: function () {
                    var filters = $('#datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}').serializeObject();

                    for (var name in filters) {
                        if (filters[name].length === 1 && filters[name][0] === '') {
                            delete filters[name];
                        }
                        if (filters[name] === '' || filters[name] === ['']) {
                            delete filters[name];
                        }
                    }

                    return filters
                }
            };
        }();

        $('.datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}').change(function () {
            wrapper.fire('changed')
        });

        $('.datepicker.datatables-filters-{{ $entity->datatables()->getEntityLowerClass() }}').on("dp.change", function (e) {
            wrapper.fire('changed')
        });
    </script>
@endsection