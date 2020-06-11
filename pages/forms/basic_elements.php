<?php
    session_start();
    header("content-type:text/html;charset=utf-8");
    $page=isset($_GET['page']) ?$_GET['page'] :1 ;//接收页码
    $page=!empty($page) ? $page :1;
    //连接数据库
    $conn=mysqli_connect("127.0.0.1","root","","message");
    mysqli_set_charset($conn,'utf8'); //设定字符集
    $table_name="Ressage_user";//查取表名设置
    $perpage=2;//每页显示的数据个数
    //最大页数和总记录数
    $total_sql="select count(*) from $table_name";
    $total_result =mysqli_query($conn,$total_sql);
    $total_row=mysqli_fetch_row($total_result);
    $total = $total_row[0];//获取最大页码数
    $total_page = ceil($total/$perpage);//向上整数
    //临界点
    $page=$page>$total_page ? $total_page:$page;//当下一页数大于最大页数时的情况
    //分页设置初始化
    $start=$page*$perpage;
    $sql= "select * from Ressage_user order by id desc limit $start ,$perpage";
    $result=mysqli_query($conn,$sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Spica Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
  <script>
        $(document).ready(function(){
            $("button").click(function(){
                //toggle方法使元素在show和hide两种状态下交换
                $("form").toggle();
            });
        });
        function foo(){
            if(myform.name.value=="")
            {
                alert("请输入你的姓名");
                myform.name.focus();
                return false;
            }
            if (myform.content.value=="")
            {
                alert("留言内容不能为空");
                myform.content.focus();
                return false;
            }
            if(myform.vcode.value==""){
            alert('验证码不能为空');
            myform.vcode.focus();
            return false;
            }
        }
    </script>
    <style type="text/css">
        table
        {
            border-collapse: collapse;
            margin: 0 auto;
            text-align: center;
        }
        table td, table th
        {
            border: 1px solid #cad9ea;
            color: #666;
            height: 30px;
        }
        table thead th
        {
            background-color: #CCE8EB;
            width: 100px;
        }
        table tr:nth-child(odd)
        {
            background: #fff;
        }
        table tr:nth-child(even)
        {
            background: #F5FAFA;
        }
        
    </style>
</head>

<body>
    
  <div class="container-scroller d-flex">
    <!-- partial:../../partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item sidebar-category">
          <p>Navigation</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../searchgame.php">
            <i class="mdi mdi-view-quilt menu-icon"></i>
            <span class="menu-title">Search Games</span>
          </a>
        </li>
        <li class="nav-item sidebar-category">
          <p>Components</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../pages/forms/basic_elements.html">
            <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">Form elements</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../pages/charts/chartjs.html">
            <i class="mdi mdi-chart-pie menu-icon"></i>
            <span class="menu-title">Charts</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../pages/tables/basic-table.html">
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">Tables</span>
          </a>
        </li>
      </ul>
    </nav>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          
          <h4 class="font-weight-bold mb-0 d-none d-md-block mt-1">Message Board</h4>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item">
              <h4 class="mb-0 font-weight-bold d-none d-xl-block">Mar.2020 - Jun.2020</h4>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
  
      </nav>
      <!-- partial -->
        <!--展示已有留言-->
        <div class="main-panel">        
        <div class="content-wrapper">
        <div id="center">
            <h1>Messages</h1>
            <?php
                if($result==NULL){echo"No messages!";}
            ?>
            <!--循环展示所有留言-->
            <table class="table">
                <thead>
                    <tr>
                    <td><span class="mdi mdi-account-circle"></span>Name</td>
                    <td><span class="mdi mdi-email-outline"></span>Email</td>
                    <td><span class="mdi mdi-content-paste"></span>Content</td>
                    <td><span class="mdi mdi-calendar"></span>Date</td>
                    <td><span class="mdi mdi-delete"></span>option</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                while($row=mysqli_fetch_array($result)){
                ?>
                <tr>
                    <td><?php echo $row['name']?></td>　　
                    <td><?php echo $row['email']?></td>
                    <td><?php echo $row['content']?></td>
                    <td style="text-align: center"><?php echo $row['ressage_time']?></td>
                    <td><a href="ressage_delete.php?id=<?php echo $row['id']?>" >delete</a> </td>
                </tr>
                <tr>
                <?php
                }?>
                </tbody>
            <table>

            <div id="baner" style="margin-top: 20px">
        <!--        显示123456等页码按钮-->
        <?php
        for($i=1;$i<=$total_page;$i++){
            if($i==$page){//当前页为显示页时加背景颜色
                echo "<a  style='padding: 5px 5px;background:#BEBEBE;color: 	#ACD6FF' href='$_SERVER[PHP_SELF]?page=$i'>$i</a>";
            }else{
                echo "<a  style='padding: 5px 5px' href='$_SERVER[PHP_SELF]?page=$i'>$i</a>";
            }
        }
        ?>
        <a href="<?php
        echo "$_SERVER[PHP_SELF]?page=".($page+1)
        ?>">Next</a>
        <a href="<?php
        echo "$_SERVER[PHP_SELF]?page={$total_page}"
        ?>">[End]</a>
        <span><?php echo $total?> pieces</span>
        </div>
    </div>
    <h1>Messages board</h1>
        <form method="post" action="ressage_post.php" style="display:none;" onsubmit="return foo();" name="myform" ">
        <div>
            <p><span class="mdi mdi-account-circle"></span>Name:</p>
            <input type="text" name="name" placeholder=".name" >
            <p><span class="mdi mdi-email-outline"></span>Email：</p>
            <input type="email" name="email"placeholder="email..." >
            <p><span class="mdi mdi-content-paste"></span>Content：<br/><textarea cols="160" rows="7" name="content"placeholder="Please write what you want to say ..." ></textarea></p>
            <p><input type="text" name="vcode"><img src="vcodes.php" onClick="this.src='vcodes.php?nocache='+Math.random()" style="cursor:hand"></p>
            <button class="btn btn-primary">Submit<button>
    </div>
    </div>
    </div>
      <div class="main-panel">        
        <div class="content-wrapper">
        <div class="table-responsive">
            <?php
                if($result==NULL){echo"暂时没有留言";}
            ?>
            <h2>Message Board</h2>
            <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
                <!--循环展示所有留言-->
                <?php
                    while($row=mysqli_fetch_array($result)){
                ?>
                <tr>
                    <td><?php echo $row['name']?></td>　　
                    <td style="text-align: center"><?php echo $row['email']?></td>
                    <td><a href="ressage_delete.php?id=<?php echo $row['id']?>" >删除</a> </td>
                    <td colspan="3"><?php echo $row['content']?></td>
                    <td><label class="badge badge-danger"><?php echo $row['ressage_time']?></label></td>
                </tr>
                <?php
                }?>
            </tbody>
            </table>
        </div>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Message Board</h4>
                  <p class="card-description">
                    Please write what you want to say...
                  </p>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="exampleInputName1">Name</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Name">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword4" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label for="exampleSelectGender">Gender</label>
                        <select class="form-control" id="exampleSelectGender">
                          <option>Male</option>
                          <option>Female</option>
                        </select>
                      </div>
                    <div class="form-group">
                      <label>File upload</label>
                      <input type="file" name="img[]" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputCity1">City</label>
                      <input type="text" class="form-control" id="exampleInputCity1" placeholder="Location">
                    </div>
                    <div class="form-group">
                      <label for="exampleTextarea1">Textarea</label>
                      <textarea class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
            <!--
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Input size</h4>
                  <p class="card-description">
                    Add classes like <code>.form-control-lg</code> and <code>.form-control-sm</code>.
                  </p>
                  <div class="form-group">
                    <label>Large input</label>
                    <input type="text" class="form-control form-control-lg" placeholder="Username" aria-label="Username">
                  </div>
                  <div class="form-group">
                    <label>Default input</label>
                    <input type="text" class="form-control" placeholder="Username" aria-label="Username">
                  </div>
                  <div class="form-group">
                    <label>Small input</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Username" aria-label="Username">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Select size</h4>
                  <p class="card-description">
                    Add classes like <code>.form-control-lg</code> and <code>.form-control-sm</code>.                    
                  </p>
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Large select</label>
                    <select class="form-control form-control-lg" id="exampleFormControlSelect1">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlSelect2">Default select</label>
                    <select class="form-control" id="exampleFormControlSelect2">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlSelect3">Small select</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Basic input groups</h4>
                  <p class="card-description">
                    Basic bootstrap input groups
                  </p>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">@</span>
                      </div>
                      <input type="text" class="form-control" placeholder="Username" aria-label="Username">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white">$</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                      <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                      </div>
                      <div class="input-group-prepend">
                        <span class="input-group-text">0.00</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username">
                      <div class="input-group-append">
                        <button class="btn btn-sm btn-primary" type="button">Search</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                          <div role="separator" class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                      </div>
                      <input type="text" class="form-control" aria-label="Text input with dropdown button">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Find in facebook" aria-label="Recipient's username">
                      <div class="input-group-append">
                        <button class="btn btn-sm btn-facebook" type="button">
                          <i class="mdi mdi-facebook"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Checkbox Controls</h4>
                  <p class="card-description">Checkbox and radio controls (default appearance is in primary color)</p>
                  <form>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input">
                              Default
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" checked>
                              Checked
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" disabled>
                              Disabled
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" disabled checked>
                              Disabled checked
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="">
                              Default
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2" checked>
                              Selected
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="optionsRadios2" id="optionsRadios3" value="option3" disabled>
                              Disabled
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="optionsRadio2" id="optionsRadios4" value="option4" disabled checked>
                              Selected and disabled
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="card-body">
                  <p class="card-description">Add class <code>.form-check-{color}</code> for checkbox and radio controls in theme colors</p>
                  <form>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="form-check form-check-primary">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" checked>
                              Primary
                            </label>
                          </div>
                          <div class="form-check form-check-success">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" checked>
                              Success
                            </label>
                          </div>
                          <div class="form-check form-check-info">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" checked>
                              Info
                            </label>
                          </div>
                          <div class="form-check form-check-danger">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" checked>
                              Danger
                            </label>
                          </div>
                          <div class="form-check form-check-warning">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" checked>
                              Warning
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="form-check form-check-primary">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="ExampleRadio1" id="ExampleRadio1" checked>
                              Primary
                            </label>
                          </div>
                          <div class="form-check form-check-success">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="ExampleRadio2" id="ExampleRadio2" checked>
                              Success
                            </label>
                          </div>
                          <div class="form-check form-check-info">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="ExampleRadio3" id="ExampleRadio3" checked>
                              Info
                            </label>
                          </div>
                          <div class="form-check form-check-danger">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="ExampleRadio4" id="ExampleRadio4" checked>
                              Danger
                            </label>
                          </div>
                          <div class="form-check form-check-warning">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="ExampleRadio5" id="ExampleRadio5" checked>
                              Warning
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Inline forms</h4>
                  <p class="card-description">
                    Use the <code>.form-inline</code> class to display a series of labels, form controls, and buttons on a single horizontal row
                  </p>
                  <form class="form-inline">
                    <label class="sr-only" for="inlineFormInputName2">Name</label>
                    <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Jane Doe">
                  
                    <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
                    <div class="input-group mb-2 mr-sm-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">@</div>
                      </div>
                      <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Username">
                    </div>
                    <div class="form-check mx-sm-2">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" checked>
                        Remember me
                      </label>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Horizontal Two column</h4>
                  <form class="form-sample">
                    <p class="card-description">
                      Personal info
                    </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">First Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Last Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Gender</label>
                          <div class="col-sm-9">
                            <select class="form-control">
                              <option>Male</option>
                              <option>Female</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date of Birth</label>
                          <div class="col-sm-9">
                            <input class="form-control" placeholder="dd/mm/yyyy"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Category</label>
                          <div class="col-sm-9">
                            <select class="form-control">
                              <option>Category1</option>
                              <option>Category2</option>
                              <option>Category3</option>
                              <option>Category4</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Membership</label>
                          <div class="col-sm-4">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios1" value="" checked>
                                Free
                              </label>
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2" value="option2">
                                Professional
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <p class="card-description">
                      Address
                    </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address 1</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">State</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address 2</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Postcode</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">City</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Country</label>
                          <div class="col-sm-9">
                            <select class="form-control">
                              <option>America</option>
                              <option>Italy</option>
                              <option>Russia</option>
                              <option>Britain</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>-->
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="card">
            <div class="card-body">
              <div class="d-sm-flex justify-content-center justify-content-sm-between py-2">
                <div class="four wide column">
                <a href="#" class="item" ><b>Return to top.<b></a>
                </div>
                <p class="text-center text-sm-left d-block d-sm-inline-block mb-0">Group Eight.IEEE Class.sjtu </p>
              </div>
            </div>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/file-upload.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
