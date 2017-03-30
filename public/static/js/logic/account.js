/**
 * Created by qiangbi on 17-3-11.
 */
$(function(){
    //添加页面
    var modal=new yii.modal();
    $("#add").click(function(){
        modal.initialization({
            url: indexinfo.addView,
            type: "post",
        });
    });
    //统一modal执行保存action
    modal.on("add",function(data){
        var data=$(modal.getid()).find("form").serialize();
        modal.remoteajax({
            url: indexinfo.addurl,
            type: "post",
            data:data,
            refresh: dataTable
        });
    });
    //统一modal执行修改action
    modal.on("edit",function(data){
        var data=$(modal.getid()).find("form").serialize();
        modal.remoteajax({
            url: indexinfo.editurl,
            type: "post",
            data:data,
            refresh: dataTable
        });
    });
    var dataTable = new yii.dataTable({
        id: "#example",
        ajax: indexinfo.datatable_url,
        columns: [
            {"data": "id","bVisible": false},
            {"data": "name"},
            {"data": "privilege_list"},
            {"data": "sort"},
            {"data": "is_on"},
            {"data": "create_time"}
        ],
        columnDefs: [
            {
                "targets": [6],
                "data": "id",
                "render": function (data, type, full) {
                    return '<button class="btn btn-primary btn-sm" _event="edit" _data="' + data + '">编辑</button>&nbsp;&nbsp;<button class="btn btn-primary btn-sm" _event="del" _data="' + data + '">删除</button>';
                }
            }
        ]
        //编辑操作
    }).on("edit", function (data) {
        modal.initialization({
            url: indexinfo.edithtml,
            data:{
                id:data
            },
            type: "post",
        });
        //删除操作
    }).on("del", function (data) {
        $.messager.confirm("删除分类","是否确认删除",function(r){
            if(r){
                modal.remoteajax({
                    url: indexinfo.delurl,
                    data:{
                        id:data
                    },
                    type: "post",
                    refresh: dataTable
                });
            }
        });
    });
    //查询
    $("#search_button").click(function(){
        var value = $("#table_check").val();
        dataTable.search(value);
    });
});


