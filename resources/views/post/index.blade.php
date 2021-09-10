@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
    <h5 class="my-0 mr-md-auto font-weight-normal">Post</h5>
    <nav class="my-2 my-md-0 mr-md-3">
    </nav>
    <a  href="javascript:void(0)" data-id="" class="btn btn-outline-primary openaddmodal">Add post</a>
  </div>
<div class="container">
    <table id="datatable" class="table table-hover datatable">
      <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">image</th>
            <th scope="col">name</th>
            <th scope="col">message</th>
            <th scope="col">status</th>
            <th scope="col">action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
</div>
<div class="modal fade add_modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body addbody">
            </div>
        </div>
    </div>
</div>
@push('script')
<script>
    $( document ).ready(function() {
        $(".datatable").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            ajax: {
                'url': "{{ url('getall') }}",
                'type': 'POST',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'image'},
                {data: 'name'},
                {data: 'message'},
                {data: 'status'},
                {data: 'action', orderable: false, 'width':'15%'},
            ]
        });

        $('body').on('click', '.openaddmodal', function () {
            var id = $(this).data('id');
            if (id == '') {
                $('.modal-title').text("Create");
            } else {
                $('.modal-title').text("Update");
            }
            $.ajax({
                url: "{{ route('getmodal')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                success: function (data) {
                    $('.addbody').html(data);
                    $('.add_modal').modal('show');
                },
            });
        });

        $('body').on('submit', '.formsubmit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('.spinner').html('<i class="fa fa-spinner fa-spin"></i>')
                },
                success: function (data) {
                    if (data.status == 400) {
                        $('.spinner').html('');
                        
                    }
                    if (data.status == 200) {
                        $('.spinner').html('');
                        $('.add_modal').modal('hide');
                        
                        $("#datatable").DataTable().ajax.reload();
                    }
                }
            });
        });

        $('body').on('click','.publishToProfile',function(){
            var id = $(this).data('id');
            $.ajax({
                url: "{{ url('page')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data:{id:id},
                success:function(data){
                    if (data.status == 200) {
                        $.confirm({
                            title: 'Success!',
                            content: data.msg,
                            autoClose: 'cancelAction|3000',
                            buttons: {
                                cancelAction: function (e) {}
                            }
                        })
                    }
                    if (data.status == 400) {
                        $.alert({
                            title: 'Alert!',
                            content: data.msg,
                        });
                    }
                }
            });
        });
    });
</script>
    
@endpush
@endsection