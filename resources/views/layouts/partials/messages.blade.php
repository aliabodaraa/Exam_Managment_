@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-success" role="alert">
                <i class="fa fa-check"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>
                <img src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 20px;height: 20px;">
            </strong>
             {{ $data }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
    @endif
@elseif(Session::get('warning', false))
    <?php $data = Session::get('warning'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-warning" role="alert">
                <i class="fa fa-check"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>
                <img src="{{ asset('images/warning.png') }}" alt="danger" style="width: 20px;height: 20px;">
            </strong>
            {{ $data }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
    @endif
@elseif(Session::get('danger', false))
    <?php $data = Session::get('danger'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-danger" role="alert">
                <i class="fa fa-check"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>
                <img src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 20px;height: 20px;">
            </strong>
            {{ $data }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
    @endif
@endif