(function ($, w) {
    var modal = function (conf) {
        return modal.self = new modal.fn.init(conf);
    };
    var dataTable = function (conf) {
        if (typeof conf != "object") {
            console.log("参数格式错误,必须是object类型");
            return;
        }
        ;
        return dataTable.self = new dataTable.fn.init(conf);
    };
    modal.Event = {
        clientList: [],
        listen: function (key, fn) {
            if (!this.clientList[key])
                this.clientList[key] = [];
            this.clientList[key].push(fn);
        },
        troggle: function () {
            var key = Array.prototype.shift.call(arguments);
            fns = this.clientList[key];
            if (!fns || fns.length === 0)
                return false;
            for (var i = 0, fn; fn = fns[i++];) {
                fn.apply(this, arguments);
            }
        },
        remove: function (key, fn) {
            var fns = this.clientList[key];
            if (!fns || fns.length === 0)
                return false;
            if (!fn) {
                fns && (fns.length = 0);
            } else {
                for (var i = fns.length - 1; i >= 0; i--) {
                    var _fn = fns[i];
                    if (_fn === fn) {
                        fns.splice(i, 1);
                    }
                }
            }
        }
    };
    modal.win=function (id,href) {
//左右居中操作 宽度合适
        var iWidth = window.screen.availWidth - 100;
        var iHeight = window.screen.availHeight - 100;
        var iLeft = (window.screen.availWidth - 10 - iWidth) / 2;           //获得窗口的水平位置;
        var location = href + '?id=' + id;
        var win_name = 'open_window_customer_' + id;
        var win = window.open(location, win_name, 'height=' + iHeight + ',width=' + iWidth + ',top=0,left=' + iLeft + ', toolbar = no, menubar = no, scrollbars = yes, resizable = no, location = no, status = no');
        if (!win || (win.closed || !win.focus) || typeof (win.document) == 'unknown' || typeof (win.document) == 'undefined') {
            alert('您的请求被拦截，请永久允许弹出窗体');
        }
        win.focus();
    };
    modal.ajax = function (conf) {
        var type = "get";
        var dataType = "json";
        if (conf.type) {
            type = conf.type;
        }
        if (conf.dataType) {
            dataType = conf.dataType;
        }
        var _this = this;
        $.ajax({
            url: conf.url,
            type: type,
            data: conf.data,
            async: conf.async || true,
            dataType: dataType,
            success: function (data) {
                if (typeof conf.success == "function") {
                    conf.success(data);
                } else {
                    var refresh = 0;
                    if (conf.refresh) {
                        refresh = conf.refresh;
                    }
                    _this.then(data, refresh);
                }
            }
        });
    };
    modal.promise = function (data) {
        (!data.title) && (data.title="提示信息");
        if (data.status == "success") {
            $.messager.show({
                title: data.title,
                msg: data.msg,
                timeout: 1000,
                showType: 'slide'
            });
        } else if (data.status == "error") {
            $.messager.alert(data.title, data.msg, "error");
        }
    };
    modal.fn = modal.prototype = {
        vertion: 1.0,
        createhtml: function () {
            var modals = ['<div class="modal fade" data-backdrop="static" role="dialog"     id="myModal' + this.id + '" tabindex="-1">'];
            modals.push('<div class="modal-dialog" role="document">');
            modals.push('<div class="modal-content" id="myContent' + this.id + '">');
            modals.push('</div></div></div>');
            modal_html = modals.join("");
            $("body").append($(modal_html));
        },
        getremotehtml: function (conf) {
            var _this = this;
            modal.ajax({
                url: conf.url,
                type: "post",
                data: conf.data,
                async: false,
                dataType: "html",
                success: function (html) {
                    $('#myContent' + _this.id).html($(html));
                    _this.bindevents(conf, html);
                    _this.scanClose();
                    _this.keydown();
                    _this.show();
                }
            });
        },
        keydown:function(){
            var _this=this;
            $(window).keydown(function(event){
                if(event.keyCode==27){
                    _this.hide();
                }
            })
        },
        init: function () {
            this.boserver={
                clientList: [],
                listen: function (key, fn) {
                    if (!this.clientList[key])
                        this.clientList[key] = [];
                    this.clientList[key].push(fn);
                },
                troggle: function () {
                    var key = Array.prototype.shift.call(arguments);
                    fns = this.clientList[key];
                    if (!fns || fns.length === 0)
                        return false;
                    for (var i = 0, fn; fn = fns[i++];) {
                        fn.apply(this, arguments);
                    }
                },
                remove: function (key, fn) {
                    var fns = this.clientList[key];
                    if (!fns || fns.length === 0)
                        return false;
                    if (!fn) {
                        fns && (fns.length = 0);
                    } else {
                        for (var i = fns.length - 1; i >= 0; i--) {
                            var _fn = fns[i];
                            if (_fn === fn) {
                                fns.splice(i, 1);
                            }
                        }
                    }
                }
            };
            this.id = Math.floor(Math.random(1, 10) * 100000000 * Math.random(1, 10));
            this.createhtml();
        },
        initialization:function(conf){
            this.getremotehtml(conf);
            return this;
        },
        remote: function (conf) {
            if (typeof conf != "object") {
                console.log("参数格式错误,必须是object2类型");
                return;
            }
            ;
            this.getremotehtml(conf);
            this.scanClose();
        },
        getid:function(){
            return "#myModal"+this.id;
        },
        show: function () {
            $('#myModal' + this.id).modal('show');
        },
        hide: function () {
            // this.boserver.clientList=[];
            $('#myModal' + this.id).modal('hide');
        },
        scanClose: function () {
            var _this = this;
            $('#myModal' + this.id).find('button[close="true"]').on("click", function () {
                _this.hide();
            });
        },
        on: function (key, fun) {
            this.boserver.listen(key, fun);
            return this;
        },
        troggle: function (key, data) {
            this.boserver.troggle(key, data);
            return this;
        },
    };
    modal.fn.remoteajax = function (conf) {
        modal.ajax.call(this, conf);
        return this;
    };
    modal.fn.bindevents = function (conf, html) {
        var arr = [];
        var _this = this;
        $('#myModal' + this.id + " [_event]").click(function(){
            _this.troggle($(this).attr("_event"),$(this).attr("_data"));
        });
    };
    modal.fn.then = function (data, refresh) {
        (!data.title) && (data.title="提示信息");
        if (data.status == "success") {
            if (refresh instanceof Object) {
                refresh.draw();
            }
            this.hide();
            window.location.reload();
        } else if (data.status == "error") {
            new PNotify({
                title: data.title,
                text: data.msg,
                type: "notice",
                delay:5000
            });
        }
    };
    modal.fn.init.prototype = modal.fn;
    dataTable.conf = {
        serverSide: true,
        searching: true,
        dom: '<"top">rt<"bottom"ip><"clear">',
        paging: true,
        language: {
            search: "查询",
            lengthMenu: "每页 _MENU_ 条记录",
            zeroRecords: "没有找到记录",
            info: "第 _PAGE_ 页 ( 总共 _PAGES_ 页 )",
            infoEmpty: "无记录",
            "oPaginate":
                {
                    "sFirst": "首页",
                    "sPrevious": "前一页",
                    "sNext": "后一页",
                    "sLast": "末页"
                },
            infoFiltered: "(从 _MAX_ 条记录过滤)"
        },
    };
    dataTable.fn = dataTable.prototype = {
        init: function (conf) {
            var baseconfig = this.scanconfig(conf);
            dataTable.instance = this.instance(conf, baseconfig);
            this.columnDefsevent(conf, conf.columnDefs[0].render());
        },
        scanconfig: function (conf) {
            if (!conf.id) {
                console.log("请输入要绑定的id元素");
                return;
            }
            if (!conf.ajax) {
                console.log("请输入ajax地址");
                return;
            }
            if (!conf.columns) {
                console.log("请输入要初始化的字段");
                return;
            }
            var baseconfig = dataTable.conf;
            baseconfig.ajax = conf.ajax;
            baseconfig.columns = conf.columns;
            if (conf.columnDefs) {
                baseconfig.columnDefs = conf.columnDefs;
            }
            return baseconfig;
        },
        on: function (key, fun) {
            modal.Event.listen(key, fun);
            return this;
        },
        troggle: function (key, data) {
            modal.Event.troggle(key, data);
            return this;
        }
    };
    dataTable.fn.columnDefsevent = function (conf, columns) {
        var arr = [];
        var _this = this;
        $(columns).each(function (index, item) {
            var type = $(item).attr("_event");
            if (type !== undefined) {
                var nodeName = $(item).prop("nodeName");
                $(conf.id).delegate(nodeName, "click", function () {
                    if ($(this).attr("_event") == type) {
                        var data = $(this).attr("_data");
                        _this.troggle(type, data);
                    }
                });
            }
        });
    };
    dataTable.fn.instance = function (conf, baseconf) {
        return $(conf.id).DataTable(baseconf);
    };
    dataTable.fn.getinstance = function () {
        return dataTable.instance;
    };
    dataTable.fn.search = function (value) {
        dataTable.instance.search(value).draw();
    };
    dataTable.fn.draw = function () {
        dataTable.instance.draw(false);
    };
    dataTable.fn.init.prototype = dataTable.fn;
    var yii = {
        modal: modal,
        dataTable: dataTable
    };
    w.yii = yii;

})($, window)
//数组去重函数
Array.prototype.unique = function() {
    // n为hash表，r为临时数组
    var n = {}, r = [];
    for (var i = 0; i < this.length; i++) {
        // 如果hash表中没有当前项
        if (!n[this[i]]) {
            // 存入hash表
            n[this[i]] = true;
            // 把当前数组的当前项push到临时数组里面
            r.push(this[i]);
        }
    }
    return r;
}
//数组取差集
Array.prototype.diff = function(a) {
    return this.filter(function(i) {return a.indexOf(i) < 0;});
};