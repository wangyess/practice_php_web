;(function () {
    'use strict';
//选中form表单
    var cat_form = document.querySelector('#cat-form');
//选中渲染的表格
    var cat_tbody = document.querySelector('#cat-tbody');
//选中表单中的select
    var cat_select = document.querySelector('[name=parent_id]');
//选中翻页上下两个按钮
    var top_page = document.querySelector('.top-page a');
    var next_page = document.querySelector('.next-page a');
//定义一个页数
    var page = 1;
//定义一个页数数量
    var page_count;
//实例化一个cat分类
    var cat = new Model('cat');
//首先获取到cat数据把select填充
    init();

    function init() {
        cat.read({'page' : 1}, render_cat_select);
        cat.read({'page' : 1}, render_cat_tbody);
        form_submit();
        cat.read_count(get_page_count);
    }

//渲染select中的各个选项
    function render_cat_select(list) {
        cat_select.innerHTML = "";
        var a_op = document.createElement('option');
        a_op.innerHTML = "默认顶级分类";
        a_op.value = 1;
        cat_select.appendChild(a_op);
        list.forEach(function (item) {
            var option = document.createElement('option');
            option.innerHTML = item.title;
            option.value = item.id;
            cat_select.appendChild(option);
        })
    }

//cat数据渲染到页面表格中
    function render_cat_tbody(list) {
        cat_tbody.innerHTML = "";
        list.forEach(function (item) {
            var tr = document.createElement('tr');
            tr.innerHTML = `
            <td>${item.id}</td>
            <td>${item.title}</td>
            <td>${item.parent_id}</td>
            <td>
            <button class="btn btn-danger" id="del_button_${item.id}"><i class="fa fa-trash"></i></button>
            <button class="btn btn-success" id="up_button_${item.id}"><i class="fa fa-edit"></i></button>
            </td>
            `;
            cat_tbody.appendChild(tr);
            //选中删除
            var del_button = document.querySelector('#del_button_' + item.id);
            del_event(del_button, item.id);
            //选中更新
            var up_button = document.querySelector('#up_button_' + item.id);
            up_event(up_button, item);
        })
    }

    //增加事件
    function form_submit() {
        cat_form.addEventListener('submit', function (e) {
            e.preventDefault();
            //获取表单数据
            var data = get_form_input(cat_form);
            //添加
            cat.add_or_update(data)
                .then(function (r) {
                    if (r.success) {
                        cat.read({'page':1, 'order' :{'by' : 'id'}}, render_cat_select);
                        cat.read_count(get_page_count);
                        cat.read({'page':1, 'order' :{'by' : 'id'}}, render_cat_tbody);
                    }
                });
        });
    }

    //获取表单数据
    function get_form_input(el) {
        var data = {};
        //选中所有input
        var input_list = el.querySelectorAll('[name]');
        for (var i = 0; i < input_list.length; i++) {
            var input = input_list[i];
            var val = input.value;
            var key = input.name;
            data[key] = val;
            input.value = "";
        }
        return data;
    }

    //删除事件
    function del_event(a, id) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            cat.remove({'id' : id});
            cat.read({'page' : page}, render_cat_select);
            //刷新翻页
            cat.read_count(get_page_count);
            //删除之后还需要重新加载页面  保持更新
            init();
        })
    }

    //更新事件
    function up_event(a, data) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            //更新 首先要把要更新的数据传到表单中
            cat.read({'page' : page}, render_cat_select);
            set_form_data(data);
        })
    }

    //把数据传到表单中
    function set_form_data(data) {
        for (var key in data) {
            //获取键值
            var val = data[key];
            //需要选中键名为key的input
            var input = document.querySelector('[name=' + key + ']');
            input.value = val;
        }
    }

    //翻页功能
    //首先获取到一共有几页

    function get_page_count(n) {
        console.log(n);
        page_count = Math.ceil(n / 10);
    }

    next_page.addEventListener('click', function (e) {
        e.preventDefault();
        if (page == page_count) {
            return;
        }
        page++;
        cat.read({'page' : page}, render_cat_tbody);
    });
    top_page.addEventListener('click', function (e) {
        e.preventDefault();
        if (page <= 1) {
            return
        }
        page--;
        cat.read({'page' : page} , render_cat_tbody);
    })
})();