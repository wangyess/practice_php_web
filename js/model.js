;(function () {
    'use strict';
    window.Model = Model;

    function Model(model_name) {
        //先是判断有没有传入这个名字
        if (!model_name) {
            throw 'invalid:model_name';
        }
        //我想要他继承他说有的方法
        this.list = [];
        this.model_name = model_name;
        this.read = read;
        this.add_or_update = add_or_update;
        this.remove = remove;
        this.read_count = read_count;
    }

    function add_or_update(row) {
        if (row.id) {
            return $.post('/admin/gateway.php?model=' + this.model_name + '&action=update', row)
        } else {
            return $.post('/admin/gateway.php?model=' + this.model_name + '&action=add', row)
        }
    }

    function remove(id) {
        var ok = confirm('确定要删除吗?');
        if (!ok) {
            return;
        } else {
            $.post('/admin/gateway.php?model=' + this.model_name + '&action=remove&id=' + id)
        }
    }

    function read(page, callback) {
        var me = this;
        return $.get('/admin/gateway.php?model=' + this.model_name + '&action=read&page=' + (page || 1))
            .then(function (r) {
                me.list = r.data;
                callback && callback(me.list);
            });
    }

    function read_count(callback) {
        $.get('/admin/gateway.php?model=' + this.model_name + '&action=read_count', function (res) {
            callback && callback(res);
        })
    }
})();