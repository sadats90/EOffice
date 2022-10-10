@extends('layouts.master')
@section('title', 'প্রকল্প')
@section('content')
    <p class="m-0 text-black-50">প্রকল্প </p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="col-md-6">
                প্রকল্প এর তালিকা
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('Project/Create') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-plus-circle-outline mr-1"></i>প্রকল্প যোগ করুন</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">ক্র নং</th>
                            <th class="text-center">প্রকল্পের নাম</th>
                            <th class="text-center">প্রকল্পের ধরণ</th>
                            <th class="text-center">কার্যক্রম</th>
                        </tr>
                    </thead>
                    @php( $initialNumber = (($projects->currentPage() -1) * $projects->perPage())+1)
                @foreach($projects as $project)
                           <tr>
                               <td class="text-center" style="width: 10%;">{{ \App\Http\Helpers\Helper::ConvertToBangla(++$i) }}</td>
                               <td>{{ $project->name }}</td>
                               <td>{{ $project->project_type == 1 ? 'রাস্তার' : 'আবাসিক/বাণিজ্যিক' }}</td>
                               <td class="text-right" style="width: 25%;">

                                   <form action="{{ route('Project/Delete', ['id'=>$project->id]) }}" method="post" id="confirm-form-alert-{{ $project->id }}">
                                       @csrf
                                       <a href="{{ route('Project/Edit',['id'=>$project->id]) }}" class="btn btn-sm btn-success"><i class="mdi mdi-square-edit-outline mr-1"></i>সম্পাদন করুন</a>
                                       @method('delete')
                                       <button type="submit" class="btn btn-danger btn-sm" onclick="return ConfirmForm('confirm-form-alert-{{ $project->id }}');"><i class="mdi mdi-delete mr-1"></i> মুছে ফেলুন</button>
                                   </form>

                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
                <nav class="float-right" aria-label="Page navigation example">
                    {{ $projects->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
