<div class="row">
    <div class="col">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show p-3" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(!empty(session('success_msg')))
            <div class="alert alert-success alert-dismissible fade show p-3" role="alert">
                <strong>Success!</strong> {{ session('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(!empty(session('error_msg')))
            <div class="alert alert-danger alert-dismissible fade show p-3" role="alert">
                <strong>Error!</strong> {{ session('error_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(!empty(session('error')))
            <div class="alert alert-danger alert-dismissible fade show p-3" role="alert">
                <div id="accordion">
                    <h5 data-toggle="collapse" data-target="#collapseErrorOne" aria-expanded="true" aria-controls="collapseErrorOne" style="border-bottom: solid 1px #999">
                        Something Error! <button class="btn" style="text-align: right"> দেখুন <i class="fas fa-chevron-down"></i></button>
                    </h5>
                    <div id="collapseErrorOne" class="collapse" data-parent="#accordion">
                        <div class="card">
                            <div class="card-body">
                                {{ session('error') }}
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>
