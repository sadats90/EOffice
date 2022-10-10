@extends('layouts.master')

@section('title', 'ডকুমেন্ট পর্যালোচনা')

@section('content')
    <p class="m-0 text-black-50"> ডকুমেন্ট পর্যালোচনা</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                  <div class="row">
                      <div class="col-md-6">
                          ডকুমেন্ট পর্যালোচনা
                      </div>
                      <div class="col-md-6 text-right">
                          @if($type == 'new')
                              <a href="{{ route('newApplication') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> নতুন আবেদন</a>
                          @elseif($type == 'FW')
                              <a href="{{ route('Application') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> ফরওয়ার্ডকৃত আবেদন সমূহ</a>
                          @else
                              <a href="{{ route('BackApplication') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> ফরওয়ার্ডকৃত আবেদন সমূহ</a>
                          @endif
                      </div>
                  </div>
               </div>
               <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @foreach($document_types as $document_type)
                                    <li class="nav-item">
                                        <a class="nav-link @if($document_type->id == 1) active @endIf" id="document-tab-{{ $document_type->id }}" data-toggle="tab" href="#tab-{{ $document_type->id }}" role="tab" aria-controls="document-tab-{{ $document_type->id }}" aria-selected="true">{{ $document_type->name }}</a>
                                    </li>
                                @endforeach

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                @foreach($document_types as $document_type)
                                    <div class="tab-pane fade @if($document_type->id == 1) show active @endIf" id="tab-{{ $document_type->id  }}" role="tabpanel" aria-labelledby="document-tab-{{ $document_type->id }}">
                                        @if(count($documents->where('document_type_id', $document_type->id)) > 0)
                                            <hr>
                                            <div class="row">
                                                @foreach($documents->where('document_type_id', $document_type->id) as $app_document)
                                                    <div class="col-md-12">
                                                        <?php
                                                        $ext = pathinfo($app_document->file)['extension'];
                                                        ?>
                                                        @if($ext == 'pdf')
                                                            <embed src="{{ asset($app_document->file) }}" style="width:100%;height: 600px;" type="application/pdf">
                                                        @else
                                                            <img src="{{ asset($app_document->file) }}" alt="Document File" style="max-width: 100%;height: auto">
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
               </div>
           </div>
       </div>
    </div>
@endsection
