<form class="formsubmit" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($data) && !empty($data->id))
        <input type="hidden" name="id" value="{{ encrypt($data->id) }}">
    @endif
    <div class="form-group">
        <label>name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ $data->name ?? '' }}" required>
    </div>
    <div class="form-group">
        <label>message</label>
        <textarea class="form-control" name="message" id="message" cols="" rows="5"
            required>{{ $data->message ?? '' }}</textarea>
    </div>
    <div class="form-group row">
        &nbsp;&nbsp; image
        <div class="col-md-12">
            <div class="avatar-upload" style="margin: 2px;">
                <div class="avatar-edit">
                    <input type="file" name="image" id="image" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit <samp class="spinner"></samp></button>
    </div>

</form>
