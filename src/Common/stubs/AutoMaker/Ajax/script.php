
@section("script")
<script language="JavaScript">
    function getGoods(id) {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "post",
            url: "{{ url('Ajax/Cat') }}",
            dataType: 'json',
            data: {
                "id": id,
            },
            success: function (data,type) {
                if(type == 'success'){
                    $("select[name='good_id']").empty();
                    $.each(data, function(id, label){
                        $("select[name='good_id']").append($("<option>").val(id).text(label));
                    });
                }
            },
        });
    };

    $("select[name='cat_id']").change(function () {
        getGoods($("select[name='cat_id']").val());
    });

    $("select[name='cat_id']").change();

</script>
@endsection
