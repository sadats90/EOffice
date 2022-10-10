<div class="row">
    <div class="col-md-12">
      <div class="row">
          <div class="col-md-6">
              <ul class="nav nav-tabs">
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('workHandover/Application') }}">
                          নতুন প্রাপ্ত আবেদন <span class="badge badge-pill badge-primary">{{ \App\Http\Helpers\Helper::ConvertToBangla($new_app_count)}}</span>
                      </a>
                  </li>
                  <li class="nav-item" role="presentation">
                      <a class="nav-link" href="{{ route('workHandover/BackApplication') }}">
                          ফেরত প্রাপ্ত আবেদন <span class="badge badge-pill badge-primary">{{ \App\Http\Helpers\Helper::ConvertToBangla($back_app_count) }}</span>
                      </a>
                  </li>
                  <li class="nav-item" role="presentation">
                      <a class="nav-link" href="{{ route('workHandover/WaitApplication') }}">
                          অপেক্ষমান আবেদন <span class="badge badge-pill badge-primary">{{ \App\Http\Helpers\Helper::ConvertToBangla($wait_app_count) }}</span>
                      </a>
                  </li>
              </ul>
          </div>
          <div class="col-md-6">
              <form action="{{ route('workHandover/Application') }}" method="get" autocomplete="off">
                  <div class="input-group input-group-sm m-0">
                      <select class="form-control form-control-sm" id="app_type" name="app_type">
                          <option value="">সব ধরণ</option>
                          <option value="Normal" @if(request()->input('app_type') == 'Normal') selected @endif>সাধারণ</option>
                          <option value="Emergency" @if(request()->input('app_type') == 'Emergency') selected @endif>জরুরী</option>
                      </select>
                      <input type="text" name="app_id" id="app_id" class="form-control form-control-sm" placeholder="আবেদন আইডি" value="{{ request()->input('app_id') }}" >
                      <input type="text" name="mobile" id="mobile" class="form-control form-control-sm" placeholder="মোবাইল নং" value="{{ request()->input('mobile') }}">
                      <div class="input-group-append">
                          <button class="input-group-text" ><i class="fas fa-search mr-1"></i> খুঁজুন</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-content">
                <div class="card">
                    <div class="card-body">
                    @include('includes.message')<!-- Message template -->
                        <div class="table-responsive" style="min-height: 150px; padding-top: 10px;">
                            @if(count($application) > 0)
                                <table class="table table-bordered table-sm pb-5">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">ক্র নং</th>
                                        <th class="text-center">আবেদন আইডি</th>
                                        <th class="text-center"> আবেদনের তারিখ</th>

                                        <th class="text-center">প্রেরক</th>
                                        <th class="text-center">প্রাপক</th>
                                        <th class="text-center">আবেদনের ধরণ</th>
                                        <th>আবেদনকারীর নাম</th>
                                        <th class="text-center">মোবাইল নম্বর</th>
                                        <th class="text-center">চিঠির শেষ তারিখ</th>
                                        <th class="text-center">অবস্থা</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php( $initialNumber = (($application->currentPage() -1) * $application->perPage())+1)
                                    @foreach($application as $i => $na)
                                        <tr>
                                            <td class="text-center align-middle">{{ \App\Http\Helpers\Helper::ConvertToBangla($initialNumber++)  }}</td>
                                            <td class="text-center align-middle">
                                                <a class="btn btn-sm btn-link" href="{{ route('application/forward',['id'=>$na->application->id, 'type' => $type]) }}">{{ \App\Http\Helpers\Helper::ConvertToBangla($na->application->app_id) }}</a>
                                            </td>
                                            <td class="text-center align-middle">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($na->application->submission_date))) }}</td>

                                            <td class="text-center align-middle">
                                                {{ $na->from_user->name }}, {{ $na->from_user->designation->name }}
                                                <p><small>{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($na->in_date))) }}</small></p>
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $na->to_user->name }}, {{ $na->to_user->designation->name }}

                                            </td>
                                            <td class="text-center align-middle">
                                                @if($na->application->app_type == 'Emergency')
                                                    <span class="bg-gray-300 px-2 text-danger"> জরুরী </span>
                                                @else
                                                    <span>সাধারণ </span>
                                                @endif
                                            </td>
                                            <td class="align-middle">{{ $na->applicant_name }} </td>
                                            <td class="text-center align-middle">{{ \App\Http\Helpers\Helper::ConvertToBangla(\App\User::find($na->application->user_id)->mobile) }} </td>

                                            <td class="text-center align-middle">
                                                @can('handoverIsInTask', ['admin:lp:li', $na->to_user_id])
                                                    @foreach($na->letters as $i => $letter)
                                                        <button class="btn btn-sm btn-link" onclick="return ShowInPopUp('{{ route("Handover/Letter/show", ["id" => $letter->id, "app_id" => $na->application->id]) }}', 'চিঠির বিস্তারিত')" title="বিস্তারিত">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter->expired_date))) }}</button>
                                                    @endforeach
                                                @endcan
                                            </td>

                                            <td class="text-center align-middle">
                                                <div class="dropdown show">
                                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0 .5rem;">
                                                        কার্যক্রম
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="{{ route('workHandover/application/view',['id'=>$na->application->id]) }}"><i class="fas fa-file-alt"></i> আবেদন পর্যালোচনা</a>
                                                        <a class="dropdown-item" href="{{ route('workHandover/application/viewPaper',['id'=>$na->application->id]) }}"><i class="fas fa-file"></i> ডকুমেন্ট পর্যালোচনা</a>
                                                        <a class="dropdown-item" href="{{ route('workHandover/application/report',['id'=>$na->application->id]) }}"><i class="fas fa-check-square"></i> আবেদন রিপোর্ট</a>
                                                        @can('handoverIsInTask', ['admin:lp:li', $na->to_user_id])
                                                            <a class="dropdown-item" href="{{ route('Handover/Letter', ['id'=>$na->application->id]) }}"><i class="fas fa-check-square"></i> চিঠি সমূহ</a>
                                                        @endcan
                                                        @can('handoverIsInTask', ['admin:fw', $na->to_user_id])
                                                            <a class="dropdown-item" href="{{ route('workHandover/application/forward',['id'=>$na->application->id, 'type' => $type]) }}"><i class="fas fa-check-square"></i> আবেদন যাচাইকরণ</a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            @else
                                <h4 class="text-center text-secondary">আবেদন খালি !</h4>
                            @endif
                        </div>

                        <!--Pagination start-->
                        <div>
                            <ul class="pagination justify-content-end">
                                {{ $application->links() }}
                            </ul>
                        </div>
                        <!--Pagination end-->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
