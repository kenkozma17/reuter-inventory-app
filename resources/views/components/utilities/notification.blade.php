<section class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            @php
                Session::forget('success');
            @endphp
        </div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            @php
                Session::forget('error');
            @endphp
        </div>
    @endif
</section>