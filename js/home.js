;(function () {
    'use strict';
    var page = 1;
    //选中分类栏
    var cat_list = document.querySelector('.cat-list');
    //选中商品区
    var product_list = document.querySelector('.product-list');
    //实例化 product cat  这个两个类
    var product = new Model('product');
    var cat = new Model('cat');

    init();

    //获取product cat 中的数据 渲染到页面
    function init() {
        product.read({'page': page}, render_product_list);
        cat.read({'page': page}, render_cat_list);
    }

    //渲染product_list
    function render_product_list(list) {
        product_list.innerHTML = "";
        list.forEach(function (item) {
            var el = document.createElement('div');
            el.className = "col-sm-4";
            el.innerHTML = `
             <div class="cover"></div>
             <div class="title">标题: ${item.title}</div>
             <div class="price">$: ${item.price}</div>
             <a class="btn btn-default price" href="/product?id=${item.id}">购买</a>
             <button class="btn btn-default" href="">加入购物车</button>
            `;
            product_list.appendChild(el);
        })
    }

    //渲染cat_list
    function render_cat_list(list) {
        cat_list.innerHTML = "";
        list.forEach(function (item) {
            var el = document.createElement('div');
            el.innerHTML = `
            <div class="cat_title">${item.title}</div>
            `;
            cat_list.appendChild(el);
        })
    }
})();