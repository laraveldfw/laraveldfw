@if(isset($alert))
    <x-alert :message="$alert['message']" :type="$alert['type']" :title="$alert['title']" />
@elseif(session('alert'))
    <x-alert :message="session('alert')" :type="session('alert-type')" :title="session('alert-title')" />
@endif
