<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>商家登陆</title>
    <!-- Bootstrap -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div class="container-fluid">
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">注册姓名</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="name" id="inputEmail3" placeholder="请输入名称" value="{{old('name')}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" name="password" id="inputEmail3" placeholder="请输入名称" value="{{old('password')}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">邮箱</label>
            <div class="col-sm-3">
                <input type="email" class="form-control" name="email" id="inputEmail3" placeholder="请输入名称" value="{{old('email')}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">商家名称</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="shop_name" id="inputEmail3" placeholder="请输入名称" value="{{old('shop_name')}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">类别</label>
            <div class="col-sm-3">
                <select class="form-control" name="shop_category_id">
                    @foreach($shop_categories as $shop_category)
                        <option value="<?=$shop_category->id?>"><?=$shop_category->name?></option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/bootstrap/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
