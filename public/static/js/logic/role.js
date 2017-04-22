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
    //权限树相关联动操作
    var privilegeTree=function(e, clickedIndex, newValue){
        var showIndex = [];
        var temp = [];
        //点击的option
        var clicked = $(this.options[clickedIndex]);
        //获取level
        var level = clicked.attr("_level");
        //获取flag
        var flag = clicked.attr("_flag");
        //获取parent_id
        var parent_id = clicked.attr("_parent_id");
        //获取值
        var val = clicked.val();
        //如果是选中的话
        if (newValue == true) {
            showIndex = $(this).val();
            $(this).find('option[_flag="' + flag + '"]').each(function (index, item) {
                var _level = $(item).attr("_level");
                var _val = $(item).val();
                //如果level大于0 说明选中的是下级元素
                if (level > 0) {
                    //如果循环的level小于当前level
                    if (_level < level) {
                        //如果level==0 直接加入进来 如果循环的值等于当前的parent_id 加入进来
                        if ((_level == "0") || (parent_id == _val))
                            showIndex.push(_val);
                    }
                    //如果level和当前的相等 并且 值也相等 说明到当前了 下面的无需再匹配 因为下面没有上级了
                    if ((_level == level) && (val == _val)) {
                        return false;
                    }
                } else if (level == 0) {
                    //如果循环的level小于当前level
                    showIndex.push(_val);
                }
            });
            $(this).selectpicker('val', showIndex.unique());
            //如果是取消选中的话
        } else {
            showIndex = $(this).val();
            if (level == 0) {
                $(this).find('option[_flag="' + flag + '"]').each(function (index, item) {
                    var _level = $(item).attr("_level");
                    var _val = $(item).val();
                    temp.push(_val);
                });
                var lastArr = showIndex.unique().diff(temp);
                $(this).selectpicker('val', lastArr);
            } else if (level == 1) {
                $(this).find('option[_flag="' + flag + '"]').each(function (index, item) {
                    var _level = $(item).attr("_level");
                    var _val = $(item).val();
                    var _parent_id = $(item).attr("_parent_id");
                    if ((_level == 2) && (val == _parent_id)) {
                        temp.push(_val);
                    }
                });
                temp.push(val);
                var lastArr = showIndex.unique().diff(temp);
                $(this).selectpicker('val', lastArr);
            }

        }



    }

