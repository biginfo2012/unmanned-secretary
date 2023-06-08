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
                dom: "<'row'<'col-sm-12 col-md-5 d-flex'<'pat-5'p><'pat-7'i>l>>\n\t\t\t<'row'<'col-sm-12'tr>>",
                lengthMenu: [20, 50, 100],
                pageLength: 20,
                language: {
                    "decimal": "",
                    "emptyTable": "現在ありません",
                    "info": "_START_~_END_/全_TOTAL_件",
                    "infoEmpty": "0~0/全0件。",
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
                    dom: "<'row'<'col-sm-12 col-md-5 d-flex'<'pat-5'p><'pat-7'i>l>>\n\t\t\t<'row'<'col-sm-12'tr>>",
                    lengthMenu: [20, 50, 100],
                    pageLength: 20,
                    language: {
                        "decimal": "",
                        "emptyTable": "現在ありません",
                        "info": "_START_~_END_/全_TOTAL_件",
                        "infoEmpty": "0~0/全0件。",
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
function changeForm(url, refresh=true){
    console.log('d')
    if($('#change_form').valid()){
        var paramObj = new FormData($('#change_form')[0]);
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
                    window.location.reload();
                }
                else {
                    toastr.warning("失敗しました。");
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

function exportFile(url, type, account){
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
            a.download = "経費一覧_" + account +  "_" + today + "." + type;
            document.body.appendChild(a);
            a.click();
        }
    });
}
function exportClientFile(url, type){
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
            a.download = "顧客情報一覧_" + "_" + today + "." + type;
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
$(document).on('change', '.change_status', function() {
    let stauts = $(this).val()
    let user_id = $(this).next().val()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });
    $.ajax({
        url: change_url,
        type: 'post',
        data: {
            user_id :user_id,
            status : stauts
        },
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
                $('#btn_get_table').trigger('click')
            }
        },
    });
});

$('#post_code_zip').on('input', function (){
    zipCloudAddress($(this).val());
})
$('.btn_search_address').click(function (){
    zipCloudAddress($('#post_code_zip').val())
})
function zipCloudAddress(value) {
    fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${value}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            $('#prefecture').val(data.results[0].address1);
            $('#city').val(data.results[0].address2);
            $('#town').val(data.results[0].address3);
        })
        .catch(error => console.log(error))
}
