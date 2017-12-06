;(function () {
    'use strict';
    var page = 1;
    var number;
    var product = new Model('product');
    var cat = new Model('cat');
    var my_form = document.querySelector('#my-form');
    var my_tbody = document.querySelector('#first-tbody');
    var cat_select = document.querySelector('[name=cat_id]');
    var top_page = document.querySelector('.top-page a');
    var next_page = document.querySelector('.next-page a');
    //.............................................................
    top_page.addEventListener('click', function (e) {
        e.preventDefault();
        if (page <= 1) {
            return;
        }
        page--;
        product.read({'page' : page,'order':{'by' : 'id'}}, product_render_all);
    });
    next_page.addEventListener('click', function (e) {
        e.preventDefault();
        console.log(number);
        if (page == number) {
            return;
        }
        page++;
        product.read({'page':page, 'order' :{'by' : 'id'}}, product_render_all);

    });
    get_count();
    //获取当前页数
    function get_count() {
        product.read_count(render_count);
    }

    function render_count(n) {
        console.log(n);
        number = Math.ceil(n / 10);
    }

    //增加
    //给表单添加提交时间
    my_form.addEventListener('submit', function (e) {
        e.preventDefault();
        //获取表中的数据
        var data = get_form_input();
        product.add_or_update(data);
        get_count();
        product.read({'page' : page , 'order':{'by':'id'} }, product_render_all);
    });

    //获取表中的数据
    function get_form_input() {
        var data = {};
        var input_list = my_form.querySelectorAll('[name]');
        for (var i = 0; i < input_list.length; i++) {
            var input = input_list[i];
            var val = input.value;
            var key = input.name;
            data[key] = val;
            input.value = "";
        }
        return data;
    }

    //获取到所有分类数据
    cat.read({'page':1}, cat_render_all);

    function cat_render_all(list) {
        cat_select.innerHTML = "";
        list.forEach(function (item) {
            var option = document.createElement('option');
            option.innerHTML = item.title;
            option.value = item.id;
            cat_select.appendChild(option);
        })

    }

    //删除
    function del_event(a, id) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            product.remove({'id' : id});
            get_count();
            product.read({page:1}, product_render_all);
        })
    }

    //更新
    function up_event(a, item) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            get_item(item);
        })
    }

    //获取数据推送到表单
    function get_item(item) {
        for (var temp in item) {
            var val = item[temp];
            var input = document.querySelector('[name=' + temp + ']');
            if (!input) {
                continue;
            }
            input.value = val;
        }
    }

    //read
    product.read({'page':1, 'order' :{'by' : 'id'}}, product_render_all);

    function product_render_all(list) {
        my_tbody.innerHTML = "";
        for (var i = 0; i < list.length; i++) {
            var item = list[i];
            var tr = document.createElement('tr');
            tr.innerHTML = `
              <td>${item.id}</td>  
              <td>${item.title}</td>  
              <td>${item.price}</td>  
              <td>${item.cat_id}</td>  
              <td>${item.count_s}</td>  
              <td>${item.des}</td>  
              <td>
                 ${select(item.hot,'hot')}
                 ${select(item.new,'new')}
              </td>
              <td>
                 <button class="btn btn-danger" id="del_button_${item.id}"><i class="fa fa-trash"></i></button>
                 <button class="btn btn-success" id="up_button_${item.id}"><i class="fa fa-edit"></i></button>
              </td>  
            `;
            my_tbody.appendChild(tr);
            var del_button = document.querySelector('#del_button_' + item.id);
            del_event(del_button, item.id);
            var up_button = document.querySelector('#up_button_' + item.id);
            up_event(up_button, item);
            //选中设置热卖或新品
            let hot =tr.querySelector('[name=hot]');
            let newSelect =tr.querySelector('[name=new]');
            hot.value = item.hot;
            newSelect.value = item.new;
            set_event(hot,item.id);
            set_event(newSelect,item.id);
        }
    }
    function set_event(el,id){
        el.addEventListener('change',function () {
            var k=el.value;
            var data ={'id':id};
            data[el.name]= Number(k);
            product.add_or_update(data);
        })
    }
    function select(val,name){
        return `<select name="${name}" value="${val}">
                    <option value="0">否</option>
                    <option value="1">是</option>
                </select>`;
    }

})();