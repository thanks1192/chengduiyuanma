define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'buy/index' + location.search,
                    add_url: 'buy/add',
                    edit_url: 'buy/edit',
                    del_url: 'buy/del',
                    multi_url: 'buy/multi',
                    import_url: 'buy/import',
                    table: 'buy',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'money_num', title: __('Money_num'), operate:'BETWEEN'},
                        {field: 'money_count', title: __('Money_count'), operate:'BETWEEN'},
                        {field: 'bank_account', title: __('Bank_account'), operate: 'LIKE'},
                        {field: 'bank_card', title: __('Bank_card'), operate: 'LIKE'},
                        {field: 'address', title: __('Address'), operate: 'LIKE'},
                        {field: 'ip', title: __('Ip'), operate: 'LIKE'},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('状态'), searchList: {0:'未处理',1:'成功',2:'失败'}, custom: {2:'danger', 1:'success'},formatter:Table.api.formatter.status},
                        {
                            field: 'buttons',
                            width: "120px",
                            title: __('审核'),
                            table: table,
                            events: Table.api.events.operate,
                            searchable: false,
                            buttons: [
                                {
                                    name: 'ajax',
                                    text: __('成功'),
                                    title: __('成功'),
                                    classname: 'btn btn-xs btn-success btn-magic btn-ajax',
                                    icon: 'fa fa-magic',
                                    url: 'buy/upstatus?status=1',
                                    refresh: true,
                                    confirm: '确认发送',
                                    visible: function (data) {
                                        if (data.status === 0) {
                                            return true;
                                        }
                                    },
                                    error: function (data, ret) {
                                        console.log(data, ret);
                                        Layer.alert(ret.msg);
                                        return false;
                                    }
                                },
                                {
                                    name: 'ajax',
                                    text: __('失败'),
                                    title: __('失败'),
                                    classname: 'btn btn-xs btn-warning btn-magic btn-ajax',
                                    icon: 'fa fa-magic',
                                    url: 'buy/upstatus?status=2',
                                    refresh: true,
                                    confirm: '确认发送',
                                    visible: function (data) {
                                        if (data.status === 0) {
                                            return true;
                                        }
                                    },
                                    error: function (data, ret) {
                                        console.log(data, ret);
                                        Layer.alert(ret.msg);
                                        return false;
                                    }
                                }
                            ],
                            formatter: Table.api.formatter.buttons
                        },
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
