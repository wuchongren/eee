@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(session()->has($msg))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="glyphicon glyphicon-trash"></i></span></button>
            <p class="alert alert-{{ $msg }}">
                {{ session()->get($msg) }}
            </p>
        </div>
    @endif
@endforeach


