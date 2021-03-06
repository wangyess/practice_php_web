<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>这个天才又来啦❤️</title>
    <style>
        .one {
            height: 740px;
            background-color: #e8efef;
        }

        label {
            margin-left: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body>
<ol class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="/adm/product">Product</a></li>
    <li class="active">Cat</li>
</ol>
<div class="page-header">
    <h1>Cat</h1>
</div>
<div class="row">
    <div class="col-xs-3 one">
        <form class="form-horizontal" id="cat-form">
            <div class="form-group">
                <label class="col-sm-10 control-label">
                    <input type="hidden" name="id" class="form-control">
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-10 control-label">
                    Title:
                    <input type="text" name="title" class="form-control">
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-10 control-label">
                    Parent_id:
                    <select name="parent_id" class="form-control">
                    </select>
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-10 control-label">
                    <button type="submit" class="btn btn-default col-sm-12">提交</button>
                </label>
            </div>
        </form>
    </div>
    <div class="col-xs-9">
        <div class="page-header">
            <h2>Show</h2>
        </div>
        <div class="show-cat-page">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Parent_id</th>
                    <th>Operation</th>
                </tr>
                <tbody id="cat-tbody">

                </tbody>
            </table>
        </div>
        <div>
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="top-page">
                        <a aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li class="next-page">
                        <a aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
<script src="/js/model.js"></script>
<script src="/js/cat.js"></script>
</body>
</html>