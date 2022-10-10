
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
                                           <div class="button-group float-right">
                                               <a href="javascript:;" download class="btn btn-sm btn-default" title="Print" onclick="printJS('{{ asset($app_document->file) }}', 'pdf');"> <i class="fas fa-print"></i> </a>
                                               <a href="{{ asset($app_document->file) }}" download class="btn btn-sm btn-default" title="Download"> <i class="fas fa-download"></i> </a>
                                               <a data-fancybox data-type="iframe" data-src="{{ asset($app_document->file) }}" href="javascript:;" class="btn btn-sm btn-default" title="View">
                                                   <i class="fas fa-expand-alt"></i>
                                               </a>
                                           </div>
                                        <embed src="{{ asset($app_document->file) }}" style="width:100%;height: 480px;" type="application/pdf">
                                    @else
                                            <div class="button-group float-right">
                                                <a href="javascript:;" download class="btn btn-sm btn-default" title="Print" onclick="printJS('{{ asset($app_document->file) }}', 'image');"> <i class="fas fa-print"></i> </a>
                                                <a href="{{ asset($app_document->file) }}" download class="btn btn-sm btn-default"> <i class="fas fa-download"></i> </a>
                                                <a data-fancybox="images"  data-src="{{ asset($app_document->file) }}" href="javascript:;" class="btn btn-sm btn-default float-right">
                                                    <i class="fas fa-expand-alt"></i>
                                                </a>
                                            </div>
                                        <img src="{{ asset($app_document->file) }}" alt="Document File" style="max-width: 100%;height: auto">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

