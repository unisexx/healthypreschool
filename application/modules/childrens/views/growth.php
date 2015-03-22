<?php
$base = array("2-0"=>"null", "2-1"=>"null", "2-2"=>"null", "2-3"=>"null", "2-4"=>"null", "2-5"=>"null", "2-6"=>"null", "2-7"=>"null", "2-8"=>"null", "2-9"=>"null", "2-10"=>"null", "2-11"=>"null",
				"3-0"=>"null", "3-1"=>"null", "3-2"=>"null", "3-3"=>"null", "3-4"=>"null", "3-5"=>"null", "3-6"=>"null", "3-7"=>"null", "3-8"=>"null", "3-9"=>"null", "3-10"=>"null", "3-11"=>"null",
				"4-0"=>"null", "4-1"=>"null", "4-2"=>"null", "4-3"=>"null", "4-4"=>"null", "4-5"=>"null", "4-6"=>"null", "4-7"=>"null", "4-8"=>"null", "4-9"=>"null", "4-10"=>"null", "4-11"=>"null",
				"5-0"=>"null", "5-1"=>"null", "5-2"=>"null", "5-3"=>"null", "5-4"=>"null", "5-5"=>"null", "5-6"=>"null", "5-7"=>"null", "5-8"=>"null", "5-9"=>"null", "5-10"=>"null", "5-11"=>"null",
				"6-0"=>"null", "6-1"=>"null", "6-2"=>"null", "6-3"=>"null", "6-4"=>"null", "6-5"=>"null", "6-6"=>"null", "6-7"=>"null", "6-8"=>"null", "6-9"=>"null", "6-10"=>"null", "6-11"=>"null",
				"6-0"=>"null");


foreach($bmis as $bmi){
	$replacements[$bmi->child_age_year.'-'.$bmi->child_age_month] = $bmi->height;
}

@$heights = array_replace($base, $replacements);

foreach($bmis as $bmi){
	$replacements[$bmi->child_age_year.'-'.$bmi->child_age_month] = $bmi->weight;
}

@$weights = array_replace($base, $replacements);
?>

<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">
$(function () {
    $('#container1').highcharts({
        chart: {
            // type: 'areaspline'
            type: 'spline'
        },
        title: {
            text: 'กราฟแสดงเกณฑ์อ้างอิงการเจริญเติบโตของเพศชาย อายุ 2-7 ปี'
        },
        xAxis: {
        	title: {
                text: 'อายุ (ปี)-(เดือน)'
            },
            categories: ['2','2-1','2-2','2-3','2-4','2-5','2-6','2-7','2-8','2-9','2-10','2-11',
            			'3','3-1','3-2','3-3','3-4','3-5','3-6','3-7','3-8','3-9','3-10','3-11',
            			'4','4-1','4-2','4-3','4-4','4-5','4-6','4-7','4-8','4-9','4-10','4-11',
            			'5','5-1','5-2','5-3','5-4','5-5','5-6','5-7','5-8','5-9','5-10','5-11',
            			'6','6-1','6-2','6-3','6-4','6-5','3-6','6-7','6-8','6-9','6-10','6-11',
            			'7'],
            labels: {
                step: 12
            }
            // categories: ['2','3','4','5','6','7',]
        },
        yAxis: {
        	title: {
                text: 'ส่วนสูง (ซม.)'
            },
            tickPositions: [80, 85, 90, 95, 100, 105, 110, 115, 120, 125, 130]
        },
        tooltip: {
            shared: true,
            valueSuffix: ' ซม.'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            },
            series: {
                connectNulls: true
            }
        },
        series: [{
        	visible: false,
            name: 'สูง',
            data: [93, null, null, null, null, null, null, null, null, null, null, null, 
            	  102.5, null, null, null, null, null, null, null, null, null, null, null, 
            	  110, null, null, null, null, null, null, null, null, null, null, null, 
            	  117, null, null, null, null, null, null, null, null, null, null, null, 
            	  123.5, null, null, null, null, null, null, null, null, null, null, null, 
            	  130]
        }, {
        	visible: false,
            name: 'ค่อนข้างสูง',
            data: [91.5, null, null, null, null, null, null, null, null, null, null, null, 
            		101, null, null, null, null, null, null, null, null, null, null, null, 
            		108, null, null, null, null, null, null, null, null, null, null, null, 
            		115, null, null, null, null, null, null, null, null, null, null, null, 
            		121.2, null, null, null, null, null, null, null, null, null, null, null, 
            		127.5]
        }, {
        	visible: false,
        	dashStyle: 'shortdot',
            name: 'ส่วนสูงตามเกณฑ์',
            data: [87, null, null, null, null, null, null, null, null, null, null, null, 
            		95, null, null, null, null, null, null, null, null, null, null, null, 
            		102, null, null, null, null, null, null, null, null, null, null, null, 
            		108, null, null, null, null, null, null, null, null, null, null, null, 
            		114.5, null, null, null, null, null, null, null, null, null, null, null, 
            		120]
        }, {
        	visible: false,
            name: 'ค่อนข้างเตี๊ย',
            data: [82.7, null, null, null, null, null, null, null, null, null, null, null, 
            		89.5, null, null, null, null, null, null, null, null, null, null, null, 
            		96, null, null, null, null, null, null, null, null, null, null, null, 
            		102, null, null, null, null, null, null, null, null, null, null, null, 
            		108, null, null, null, null, null, null, null, null, null, null, null, 
            		113]
        }, {
        	visible: false,
            name: 'เตี๊ย',
            data: [81, null, null, null, null, null, null, null, null, null, null, null, 
            		87.5, null, null, null, null, null, null, null, null, null, null, null, 
            		94, null, null, null, null, null, null, null, null, null, null, null, 
            		100, null, null, null, null, null, null, null, null, null, null, null, 
            		105.5, null, null, null, null, null, null, null, null, null, null, null, 
            		110.5]
        }, {
            name: '<?=$classroom_detail->title.''.$classroom_detail->child_name?>',
            data: [<?foreach($heights as $heitht):?><?=$heitht?>,<?endforeach;?>]
        }],
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: null,
                    onclick: function () {
                        this.print();
                    }
                }
            }
        }
    });
    
    
    $('#container2').highcharts({
        chart: {
            // type: 'areaspline'
            type: 'spline'
        },
        title: {
        	visible: false,
            text: ' .'
        },
        xAxis: {
        	title: {
                text: 'อายุ (ปี)'
            },
            categories: ['2','2-1','2-2','2-3','2-4','2-5','2-6','2-7','2-8','2-9','2-10','2-11',
            			'3','3-1','3-2','3-3','3-4','3-5','3-6','3-7','3-8','3-9','3-10','3-11',
            			'4','4-1','4-2','4-3','4-4','4-5','4-6','4-7','4-8','4-9','4-10','4-11',
            			'5','5-1','5-2','5-3','5-4','5-5','5-6','5-7','5-8','5-9','5-10','5-11',
            			'6','6-1','6-2','6-3','6-4','6-5','3-6','6-7','6-8','6-9','6-10','6-11',
            			'7'],
            labels: {
                step: 12
            }
        },
        yAxis: {
        	title: {
                text: 'น้ำหนัก (กก.)'
            },
            tickPositions: [8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31]
        },
        tooltip: {
            shared: true,
            valueSuffix: ' กก.'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            },
            series: {
                connectNulls: true
            }
        },
        series: [{
        	visible: false,
            name: 'น้ำหนักมากเกินเกณฑ์',
            data: [15, null, null, null, null, null, null, null, null, null, null, null, 
            		18, null, null, null, null, null, null, null, null, null, null, null, 
            		21, null, null, null, null, null, null, null, null, null, null, null, 
            		24.3, null, null, null, null, null, null, null, null, null, null, null, 
            		27.3, null, null, null, null, null, null, null, null, null, null, null, 
            		31]
        }, {
        	visible: false,
            name: 'น้ำหนักค่อนข้างมาก',
            data: [14.5, null, null, null, null, null, null, null, null, null, null, null, 
            		17.2, null, null, null, null, null, null, null, null, null, null, null, 
            		20, null, null, null, null, null, null, null, null, null, null, null,  
            		22.5, null, null, null, null, null, null, null, null, null, null, null,  
            		25.5, null, null, null, null, null, null, null, null, null, null, null, 
            		29]
        }, {
        	visible: false,
        	dashStyle: 'shortdot',
            name: 'น้ำหนักตามเกณฑ์',
            data: [12.5, null, null, null, null, null, null, null, null, null, null, null, 
            		14.5, null, null, null, null, null, null, null, null, null, null, null,  
            		16.3, null, null, null, null, null, null, null, null, null, null, null,  
            		17.8, null, null, null, null, null, null, null, null, null, null, null,  
            		19.8, null, null, null, null, null, null, null, null, null, null, null,  
            		22]
        }, {
        	visible: false,
            name: 'ค่อนข้างน้อย',
            data: [10.5, null, null, null, null, null, null, null, null, null, null, null, 
            		12.2, null, null, null, null, null, null, null, null, null, null, null, 
            		13.5, null, null, null, null, null, null, null, null, null, null, null, 
            		15, null, null, null, null, null, null, null, null, null, null, null, 
            		16.5, null, null, null, null, null, null, null, null, null, null, null, 
            		18.3]
        }, {
        	visible: false,
            name: 'น้อยกว่าเกณฑ์',
            data: [9.8,  null, null, null, null, null, null, null, null, null, null, null, 
		            11.5,  null, null, null, null, null, null, null, null, null, null, null, 
		            12.5,  null, null, null, null, null, null, null, null, null, null, null, 
		            14,  null, null, null, null, null, null, null, null, null, null, null, 
		            15.5,  null, null, null, null, null, null, null, null, null, null, null, 
		            17]
        }, {
            name: '<?=$classroom_detail->title.''.$classroom_detail->child_name?>',
            data: [<?foreach($weights as $weight):?><?=$weight?>,<?endforeach;?>]
        }],
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: null,
                    onclick: function () {
                        this.print();
                    }
                }
            }
        }
    });
    
    
    $('#container3').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: 'กราฟแสดงเกณฑ์อ้างอิงการเจริญเติบโตของเพศหญิง อายุ 2-7 ปี'
        },
        xAxis: {
        	title: {
                text: 'อายุ (ปี)-(เดือน)'
            },
            categories: ['2','2-1','2-2','2-3','2-4','2-5','2-6','2-7','2-8','2-9','2-10','2-11',
            			'3','3-1','3-2','3-3','3-4','3-5','3-6','3-7','3-8','3-9','3-10','3-11',
            			'4','4-1','4-2','4-3','4-4','4-5','4-6','4-7','4-8','4-9','4-10','4-11',
            			'5','5-1','5-2','5-3','5-4','5-5','5-6','5-7','5-8','5-9','5-10','5-11',
            			'6','6-1','6-2','6-3','6-4','6-5','3-6','6-7','6-8','6-9','6-10','6-11',
            			'7'],
            labels: {
                step: 12
            }
        },
        yAxis: {
        	title: {
                text: 'ส่วนสูง (ซม.)'
            },
            tickPositions: [75, 80, 85, 90, 95, 100, 105, 110, 115, 120, 125, 130]
        },
        tooltip: {
            shared: true,
            valueSuffix: ' ซม.'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            },
            series: {
                connectNulls: true
            }
        },
        series: [{
        	visible: false,
            name: 'สูง',
            data: [92, null, null, null, null, null, null, null, null, null, null, null, 
            	  101, null, null, null, null, null, null, null, null, null, null, null, 
            	  109, null, null, null, null, null, null, null, null, null, null, null, 
            	  116, null, null, null, null, null, null, null, null, null, null, null, 
            	  123, null, null, null, null, null, null, null, null, null, null, null, 
            	  129]
        }, {
        	visible: false,
            name: 'ค่อนข้างสูง',
            data: [90, null, null, null, null, null, null, null, null, null, null, null, 
            		99, null, null, null, null, null, null, null, null, null, null, null, 
            		107, null, null, null, null, null, null, null, null, null, null, null, 
            		114, null, null, null, null, null, null, null, null, null, null, null, 
            		121, null, null, null, null, null, null, null, null, null, null, null, 
            		127]
        }, {
        	visible: false,
        	dashStyle: 'shortdot',
            name: 'ส่วนสูงตามเกณฑ์',
            data: [85, null, null, null, null, null, null, null, null, null, null, null, 
            		94, null, null, null, null, null, null, null, null, null, null, null, 
            		101, null, null, null, null, null, null, null, null, null, null, null, 
            		107.5, null, null, null, null, null, null, null, null, null, null, null, 
            		114, null, null, null, null, null, null, null, null, null, null, null, 
            		120]
        }, {
        	visible: false,
            name: 'ค่อนข้างเตี๊ย',
            data: [80, null, null, null, null, null, null, null, null, null, null, null, 
            		88, null, null, null, null, null, null, null, null, null, null, null, 
            		95, null, null, null, null, null, null, null, null, null, null, null, 
            		101, null, null, null, null, null, null, null, null, null, null, null, 
            		107.5, null, null, null, null, null, null, null, null, null, null, null, 
            		112.5]
        }, {
        	visible: false,
            name: 'เตี๊ย',
            data: [78.5, null, null, null, null, null, null, null, null, null, null, null, 
            		86, null, null, null, null, null, null, null, null, null, null, null, 
            		93, null, null, null, null, null, null, null, null, null, null, null, 
            		99, null, null, null, null, null, null, null, null, null, null, null, 
            		105, null, null, null, null, null, null, null, null, null, null, null, 
            		110]
        }, {
            name: '<?=$classroom_detail->title.''.$classroom_detail->child_name?>',
            data: [<?foreach($heights as $heitht):?><?=$heitht?>,<?endforeach;?>]
        }],
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: null,
                    onclick: function () {
                        this.print();
                    }
                }
            }
        }
    });
    
    
    $('#container4').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
        	visible: false,
            text: ' .'
        },
        xAxis: {
        	title: {
                text: 'อายุ (ปี)'
            },
            categories: ['2','2-1','2-2','2-3','2-4','2-5','2-6','2-7','2-8','2-9','2-10','2-11',
            			'3','3-1','3-2','3-3','3-4','3-5','3-6','3-7','3-8','3-9','3-10','3-11',
            			'4','4-1','4-2','4-3','4-4','4-5','4-6','4-7','4-8','4-9','4-10','4-11',
            			'5','5-1','5-2','5-3','5-4','5-5','5-6','5-7','5-8','5-9','5-10','5-11',
            			'6','6-1','6-2','6-3','6-4','6-5','3-6','6-7','6-8','6-9','6-10','6-11',
            			'7'],
            labels: {
                step: 12
            }
        },
        yAxis: {
        	title: {
                text: 'น้ำหนัก (กก.)'
            },
            tickPositions: [8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31]
        },
        tooltip: {
            shared: true,
            valueSuffix: ' กก.'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            },
            series: {
                connectNulls: true
            }
        },
        series: [{
        	visible: false,
        	// color: '#1B9850',
            name: 'น้ำหนักมากเกินเกณฑ์',
            data: [14.5, null, null, null, null, null, null, null, null, null, null, null, 
            		17.5, null, null, null, null, null, null, null, null, null, null, null, 
            		20.5, null, null, null, null, null, null, null, null, null, null, null, 
            		23, null, null, null, null, null, null, null, null, null, null, null, 
            		26.5, null, null, null, null, null, null, null, null, null, null, null, 
            		31]
        }, {
        	visible: false,
        	// color: '#66BD6D',
            name: 'น้ำหนักค่อนข้างมาก',
            data: [13.75, null, null, null, null, null, null, null, null, null, null, null, 
            		16.5, null, null, null, null, null, null, null, null, null, null, null, 
            		19, null, null, null, null, null, null, null, null, null, null, null,  
            		21.5, null, null, null, null, null, null, null, null, null, null, null,  
            		24.75, null, null, null, null, null, null, null, null, null, null, null, 
            		28.5]
        }, {
        	visible: false,
        	// color: '#66BD6D',
        	dashStyle: 'shortdot',
            name: 'น้ำหนักตามเกณฑ์',
            data: [11.5, null, null, null, null, null, null, null, null, null, null, null, 
            		14, null, null, null, null, null, null, null, null, null, null, null,  
            		15.75, null, null, null, null, null, null, null, null, null, null, null,  
            		17.5, null, null, null, null, null, null, null, null, null, null, null,  
            		19.5, null, null, null, null, null, null, null, null, null, null, null,  
            		21.5]
        }, {
        	visible: false,
        	// color: '#9AD595',
            name: 'ค่อนข้างน้อย',
            data: [9.7, null, null, null, null, null, null, null, null, null, null, null, 
            		11.5, null, null, null, null, null, null, null, null, null, null, null, 
            		13, null, null, null, null, null, null, null, null, null, null, null, 
            		14.5, null, null, null, null, null, null, null, null, null, null, null, 
            		16.25, null, null, null, null, null, null, null, null, null, null, null, 
            		17.5]
        }, {
        	visible: false,
        	// color: '#FE8014',
            name: 'น้อยกว่าเกณฑ์',
            data: [9,  null, null, null, null, null, null, null, null, null, null, null, 
		            10.5,  null, null, null, null, null, null, null, null, null, null, null, 
		            12,  null, null, null, null, null, null, null, null, null, null, null, 
		            13.5,  null, null, null, null, null, null, null, null, null, null, null, 
		            15,  null, null, null, null, null, null, null, null, null, null, null, 
		            16.5]
        }, {
            name: '<?=$classroom_detail->title.''.$classroom_detail->child_name?>',
            data: [<?foreach($weights as $weight):?><?=$weight?>,<?endforeach;?>]
        }],
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: null,
                    onclick: function () {
                        this.print();
                    }
                }
            }
        }
    });
    
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="childrens?nursery_id=<?=$_GET['nursery_id']?>">ตรวจสอบรายชื่อ / เด็กนักเรียน</a> <span class="divider">/</span></li>
  <li>เกณฑ์การเจริญเติบโต</li>
</ul>

<h1><a href="childrens/profile/<?=$classroom_detail->id?>"><?=$classroom_detail->title.''.$classroom_detail->child_name?></a></h1>

<?if($classroom_detail->title == 'ด.ช.'):?>
<div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<?elseif($classroom_detail->title == 'ด.ญ.'):?>
<div id="container3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="container4" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<?endif;?>