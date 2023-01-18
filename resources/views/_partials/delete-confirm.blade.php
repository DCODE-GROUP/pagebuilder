<div class="reveal" id="deleteConfirmation_{{ class_basename($object) . $object->id }}" data-reveal>
    <p>Are you sure you want to delete {!! $label !!}?</p>
    @if (isset($message) && is_array($message))
    <div class="-extra -{{ $message['class'] }}">
        <h4>{{ $message['text'] }}</h4>
    </div>
    @endif
    <div class="flex space-x-4">
        {!! Form::open(['route' => [$route, $object], 'method' => 'delete', "class" => 'flex space-x-4']) !!}
        <button class="btn btn-primary-outlined" data-close aria-label="Close modal" type="button">Cancel</button>
        {{ Form::submit('Delete', ['class' => 'btn btn-primary']) }}
        {!! Form::close() !!}
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<a {!! ((isset($anchor) && $anchor) ? '' : 'class="button alert"' ) !!} data-open="deleteConfirmation_{{ class_basename($object) . $object->id }}">Delete {{ $type }}</a>