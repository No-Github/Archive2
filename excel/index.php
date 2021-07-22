<?php
//引入类库
include "./PHPExcel-1.8.2/Classes/PHPExcel/IOFactory.php";
header('Content-type:text/html;charset=utf-8');
error_reporting(0);
// 文件上传文件处理
//if ($_FILES["file"]["error"] > 0)
//  {
//  echo "Error: " . $_FILES["file"]["error"] . "<br/>";
//  }
//else
//  {
//  echo "Upload: " . $_FILES["file"]["name"] . "<br/>";
//  echo "Type: " . $_FILES["file"]["type"] . "<br/>";
//  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br/>";
//  echo "Stored in: " . $_FILES["file"]["tmp_name"];
//  }

if ($_FILES["file"]["name"] == null){
    ?>
    <link href="./css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <div class="mb-3">
        <label for="formFile" class="form-label">请上传文件,支持.txt,.csv,.xlsx</label>
        <form method="post" enctype="multipart/form-data" action="index.php">
            <input class="form-control"  name="file" type="file" style="width: 400px;">
            <input type="submit" class="btn btn-outline-secondary" value="上传" style="margin-top: -40px;margin-left: 410px">
        </form>
    </div>

<?php

}

else{

if ((($_FILES["file"]["type"] == "application/vnd.ms-excel")
        || ($_FILES["file"]["type"] == "text/plain")
        || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"))
    && ($_FILES["file"]["size"] < 20000))
{
//elsx文件路径
    @$inputFileName = @$_FILES["file"]["tmp_name"];
}
else
{
    echo "<script>alert('我滚你妈的传的什么勾8');</script>";
    ?>
    <link href="./css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <div class="mb-3">
        <label for="formFile" class="form-label">请上传文件,支持.txt,.csv,.xlsx</label>
        <form method="post" enctype="multipart/form-data" action="index.php">
            <input class="form-control"  name="file" type="file" style="width: 400px;">
            <input type="submit" class="btn btn-outline-secondary" value="上传" style="margin-top: -40px;margin-left: 410px">
        </form>
    </div>
<?php
}

date_default_timezone_set('PRC');
// 读取excel文件
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {

}

$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

$a = 0;
$result = array();
// 获取excel文件的数据，$row=2代表从第二行开始获取数据
for ($row = 2; $row <= $highestRow; $row++){
// 循环查询数据放入嵌套数组
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

// 测试
//    print_r($rowData);
//    var_dump($rowData);
// 循环查询数组个数
    $arr = $rowData[0];
    foreach ($arr as $str) {
        $str_arr = explode(',', $str);
        foreach ($str_arr as $v) {
            $result[$v] = isset($result[$v]) ? $result[$v] : 0;
            $result[$v] = $result[$v] + 1;
        }
    }

}
arsort($result);

//var_dump($result);
// 打印数组
//print_r($result);
//foreach($result as $number=>$value)
//{
//    //    {value: 27, name: '8080'},
//    echo "{value: ".$value.",name: '" . $number . "'},\n";
//}

?>
<!DOCTYPE html>
<html style="height: 100%">
<head>
    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/No-Github/Archive2@1.0.4/html/images/ffffffff0x-64.ico" type="image/x-icon">
    <meta charset="utf-8">
</head>
<body style="height: 100%; margin: 0">

<div class="mb-3">
    <label for="formFile" class="form-label">请上传文件,支持.txt,.csv,.xlsx</label>
    <form method="post" enctype="multipart/form-data" action="index.php">
        <input class="form-control"  name="file" type="file" style="width: 400px;">
        <input type="submit" class="btn btn-outline-secondary" value="上传" style="margin-top: -65px;margin-left: 410px">
    </form>
</div>

<div style="height: 800px;position: absolute;">
<div id="container" style="height: 500px;width: 800px;margin-top: 5%"></div>

<link href="./css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script type="text/javascript" src="js/echarts.min.js"></script>


<script type="text/javascript">
    var dom = document.getElementById("container");
    var myChart = echarts.init(dom);
    var app = {};
    var option;
    option = {
        tooltip: {
            trigger: 'item'
        },

        series: [
            {
                type: 'pie',
            },
            {
                name: '端口号',
                type: 'pie',
                radius: ['40%', '70%'],
                itemStyle: {
                    borderRadius: 10,
                    borderColor: '#fff',
                    borderWidth: 2
                },

                label: {
                    formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}个  {per|{d}%}  ',
                    backgroundColor: '#F6F8FC',
                    borderColor: '#8C8D8E',
                    borderWidth: 1,
                    borderRadius: 4,

                    rich: {
                        a: {
                            color: '#6E7079',
                            lineHeight: 22,
                            align: 'center'
                        },
                        hr: {
                            borderColor: '#8C8D8E',
                            width: '100%',
                            borderWidth: 1,
                            height: 0
                        },
                        b: {
                            color: '#4C5058',
                            fontSize: 14,
                            fontWeight: 'bold',
                            lineHeight: 33
                        },
                        per: {
                            color: '#fff',
                            backgroundColor: '#4C5058',
                            padding: [3, 4],
                            borderRadius: 4
                        }
                    }
                },

                labelLine: {
                    length: 30,
                },
                data: [
                    // {value: 27, name: '8080'},
                    <?php
                    foreach($result as $number=>$value)
                    {
                    //    {value: 27, name: '8080'},
                        echo "{value: ".$value.",name: '" . $number . "'},\n";
                    }
                    ?>
                    ]
            }
        ]
    };

    if (option && typeof option === 'object') {
        myChart.setOption(option);
    }
</script>

<div style="margin-left: 98%;margin-top: -55%;width: 200px;position: absolute;">
<table class="table table-striped" style="height: 200px;">
    <tr>
        <th scope="col">端口 TOP10</th>
        <th scope="col">个数</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $i = 0;
        foreach ($result as $number => $value) {
            if ($i++ > 9) break;
            echo "<tr><th scope='row'>".$number."</th><td>".$value."</td></tr>";
        }
    }
        ?>

<!--    <tr><th scope="row">1</th><td>Mark</td></tr>-->
<!--    <tr><th scope="row">2</th><td>Jacob</td></tr>-->
<!--    <tr><th scope="row">3</th><td colspan="2">Larry the Bird</td>-->

    </tr>
    </tbody>
</table>
</div>
</div>

<script src="./js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
