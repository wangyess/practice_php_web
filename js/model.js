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
            return $.post('/a/' + this.model_name + '/update', row)
        } else {
            console.log(row);
            return $.post('/a/' + this.model_name + '/add', row)
        }
    }

    function remove(data) {
        var ok = confirm('确定要删除吗?');
        if (!ok) {
            return;
        } else {
            $.post('/a/' + this.model_name + '/remove', data)
        }
    }

    function read(data, callback) {
        var me = this;
        $.post('/a/' + this.model_name + '/read', data)
            .then(function (r) {
                me.list = r.data;
                callback && callback(me.list);
            });
    }

    function read_count(callback) {
        $.get('/a/' + this.model_name + '/read_count', function (res) {
            callback && callback(res);
        })
    }
})();