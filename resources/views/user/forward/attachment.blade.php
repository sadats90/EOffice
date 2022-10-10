<div class="row">
    <div class="col-md-10 offset-1">
        <div class="card">
            <div class="card-header">
                <span class="card-title">সংযুক্তি আপলোড</span>
            </div>
            <div class="card-body p-2">
                <form autocomplete="off" action="{{ route('attachment/store', ['id' => $id]) }}" method="post" onsubmit="return PostForm(this)" enctype="multipart/form-data">
                   @csrf
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <input class="form-control form-control-sm" type="file" name="attach_file" required>
                        </div>
                        <div class="col-md-5">
                            <input class="form-control form-control-sm" type="text" name="name" required>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success btn-sm" type="submit"><i class="fas fa-upload"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-header">
                <span class="card-title">সংযুক্তি সমুহ</span>
            </div>
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-bordered table-hover mb-0">
                            <thead>
                            <tr>
                                <th class="pt-0" style="width: 10%">ক্র নং</th>
                                <th class="pt-0">নাম</th>
                                <th class="pt-0 text-center" style="width: 15%"> মুছে ফেলুন</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($sl = 1)
                                @foreach($attachments as $attachment)
                                    <tr>
                                        <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($sl) }}</td>
                                        <td>
                                            <a href="{{asset($attachment->path)}}" data-fancybox="gallery" data-caption=" {{ $attachment->name }}">
                                                {{ $attachment->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('attachment/Delete', ['id' => $attachment->id, 'app_id' => $id]) }}" onsubmit="return PostForm(this)">
                                                @csrf
                                                <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @php($sl++)
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
