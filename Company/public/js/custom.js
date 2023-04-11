function getTableData(url) {
    var paramObj = new FormData($('#search_form')[0]);
    $.ajax({
        url: url,
        type: 'post',
        data: paramObj,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#table-part').html(response);
            var t = $('#table');
            t.DataTable({
                responsive: !0,
                dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [20, 50, 100],
                pageLength: 20,
                language: {
                    "decimal": "",
                    "emptyTable": "現在ありません",
                    "info": "_TOTAL_中_START_から_END_を表示",
                    "infoEmpty": "0~0の0を表示。",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": " _MENU_ ",
                    "loadingRecords": "ロード中...",
                    "processing": "処理中...",
                    "search": "検索:",
                    "zeroRecords": "一致する検索資料がありません。",
                    "paginate": {
                        "first": "初めに",
                        "last": "最後",
                        "next": "次へ",
                        "previous": "前へ"
                    },
                },
            });
        },
        error: function () {

        }
}

)
    ;
}
function getTableDataNo(url) {
    var paramObj = new FormData($('#search_form')[0]);
    $.ajax({
            url: url,
            type: 'post',
            data: paramObj,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#table-part').html(response);
                var t = $('#table');
                t.DataTable({
                    responsive: !0,
                    dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'p>>",
                    pageLength: 20,
                    language: {
                        "decimal": "",
                        "emptyTable": "現在ありません",
                        "info": "_TOTAL_中_START_から_END_を表示",
                        "infoEmpty": "0~0の0を表示。",
                        "infoFiltered": "(filtered from _MAX_ total entries)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": " _MENU_ ",
                        "loadingRecords": "ロード中...",
                        "processing": "処理中...",
                        "search": "検索:",
                        "zeroRecords": "一致する検索資料がありません。",
                        "paginate": {
                            "first": "初めに",
                            "last": "最後",
                            "next": "次へ",
                            "previous": "前へ"
                        },
                    },
                });
            },
            error: function () {

            }
        }

    )
    ;
}
function saveForm(url, refresh=true){
    console.log('d')
    if($('#save_form').valid()){
        var paramObj = new FormData($('#save_form')[0]);
        $.ajax({
            url: url,
            type: 'post',
            data: paramObj,
            contentType: false,
            processData: false,
            success: function(response){
                console.log(response);
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                if(response.status == true){
                    toastr.success("成功しました。");
                    if(refresh){
                        GoBackWithRefresh()
                    }
                }
                else {
                    if(response.result == 'subject_already_exist'){
                        toastr.warning("勘定科目名が既に存在します。")
                    }
                    else{
                        toastr.warning("失敗しました。");
                    }
                }


            },
        });
    }
}
function deleteData(id, url){
    Swal.fire({
        title: '本当に削除しますか？',
        text: "これを戻すことができません！",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'はい',
        cancelButtonText: 'キャンセル',
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            $.ajax({
                url: url,
                type:'post',
                data: {
                    id : id
                },
                success: function (response) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    if(response.status == true){
                        Swal.fire({
                            icon: 'success',
                            title: '削除しました！',
                            // text: '削除しました！',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }).then(function (result) {
                            if (result.value) {
                                GoBackWithRefresh()
                            }});
                        //toastr.success("成功しました。");
                    }
                    else {
                        toastr.warning("失敗しました。");
                    }
                },
                error: function () {

                }
            });

        }
    });

}

$('#btn_cancel').click(function (e) {
    GoBackWithRefresh()
});
function goBackIE() {
    // javascript: history.go(-1);
    // location.reload(true);
    window.history.back();
    location.reload();
}
function GoBackWithRefresh(event) {
    if ('referrer' in document) {
        window.location = document.referrer;
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}

function exportExcel(url){
    var paramObj = new FormData($("#search_form")[0]);
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today =yyyy+mm+dd;
    $.ajax({
        url: url,
        type: 'post',
        data: paramObj,
        contentType: false,
        processData: false,
        xhrFields:{
            responseType: 'blob'
        },
        success: function (result) {
            var blob = result;
            var downloadUrl = URL.createObjectURL(blob);
            var a = document.createElement("a");
            a.href = downloadUrl;
            a.download = "経費一覧" + today + ".xlsx";
            document.body.appendChild(a);
            a.click();
        }
    });
}
$(".flatpickr").flatpickr({
    "locale": "ja",
    dateFormat: "Y/m/d",
    maxDate: "today",
})
$('#cost-img').click(function (e) {
    let src = $(this).attr('src')
    $('#imageModal').modal('show')
    $('#modal-img').attr('src', src)
});
