<div class="py-12" id="deleteConfirmation_{{ class_basename($object) . $object->id }}">
    <div class="mb-6 text-center">
        <h4>Are you sure you want to delete<br><strong class="text-brand-green">{!! $label !!}</strong>?</h4>
    </div>

    @if (isset($message) && is_array($message))
    <div class="-extra -{{ $message['class'] }}">
        <h4>{{ $message['text'] }}</h4>
    </div>
    @endif

    {!! Form::open(['route' => [$route, $object], 'method' => 'delete', "class" => 'flex justify-center']) !!}
    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
    {!! Form::close() !!}
</div>