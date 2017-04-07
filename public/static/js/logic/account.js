/**
 * Created by qiangbi on 17-3-11.
 */
var modal=new yii.modal();
//添加页面
$("#add").click(function(){
    modal.initialization({
        url: indexinfo.addView,
        type: "post",
    });
});
//修改页面
$(".edit").click(function(){
    var id=$(this).attr("_attr");
    modal.initialization({
        url: indexinfo.saveView,
        type: "post",
        data:{
            id:id
        }
    });
});
$(".del").click(function(){
    var id=$(this).attr("_attr");
    modal.initialization({
        url:indexinfo.delView,
        type: "post",
        data:{
            id:id
        }
    });
});
//统一modal执行保存action
modal.on("add",function(data){
    var data=$(modal.getid()).find("form").serialize();
    modal.remoteajax({
        url: indexinfo.addUrl,
        type: "post",
        data:data
    });
});
//统一modal执行修改action
modal.on("edit",function(data){
    var data=$(modal.getid()).find("form").serialize();
    modal.remoteajax({
        url: indexinfo.saveUrl,
        type: "post",
        data:data,
    });
});
//同意modal执行删除操作
modal.on("delConfirm",function(data){
    modal.remoteajax({
        url: indexinfo.delUrl,
        type: "post",
        data:{
            id:data
        },
    });
});

