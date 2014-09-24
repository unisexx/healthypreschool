<script type="text/javascript" src="media/js/highchart/highcharts.js"></script>
<script type="text/javascript" src="media/js/highchart/modules/exporting.js"></script>
<script type="text/javascript">
$(function(){
	var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'column'
            },
            title: {
                text: 'ผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ 2554-2555 แยกตาม',
                x: -20 //center
            },
            subtitle: {
                text: ' ',
                x: -20
            },
            xAxis: {
                categories: ['<a href="nurseries/area_report/1">สคร.1</a>', '<a href="nurseries/area_report/2">สคร.2</a>', '<a href="nurseries/area_report/3">สคร.3</a>', '<a href="nurseries/area_report/4">สคร.4</a>', '<a href="nurseries/area_report/5">สคร.5</a>', '<a href="nurseries/area_report/6">สคร.6</a>',
                    '<a href="nurseries/area_report/7">สคร.7</a>', '<a href="nurseries/area_report/8">สคร.8</a>', '<a href="nurseries/area_report/9">สคร.9</a>', '<a href="nurseries/area_report/10">สคร.10</a>', '<a href="nurseries/area_report/11">สคร.11</a>', '<a href="nurseries/area_report/12">สคร.12</a>']
            },
            yAxis: {
                title: {
                    text: 'จำนวนศูนย์เด็กเล็กปลอดโรค'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'ศูนย์';
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 380,
                y: 60,
                floating: true,
                shadow: true
            },
            series: [{
                name: 'จำนวนศูนย์เด็กเล็กในพื้นที่ (แห่ง)',
                data: [546, 720, 1298, 1225, 2062, 3461, 3068, 820, 1184, 2778, 1079, 1261]
                // data: [<?php
                		// for ($i=1; $i<=12; $i++){
							// $nursery[$i] = new Nursery();
							// $nursery[$i]->select("COUNT(area_id) AS regis_count")->where("area_id = ".$i)->get();
							// echo $nursery[$i]->regis_count.',';
						// }
                	// ?>]
            }, {
                name: 'จำนวนศูนย์เด็กเล็กที่เข้าร่วมโครงการ (แห่ง)',
                data: [<?php
                		for ($i=1; $i<=12; $i++){
							$nursery[$i] = new Nursery();
							$nursery[$i]->select("COUNT(area_id) AS regis_count")->where("area_id = ".$i)->get();
							echo $nursery[$i]->regis_count.',';
						}
                	?>]
            }]
        });
    });
});
</script>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="nurseries">ศูนย์เด็กเล็กปลอดโรค</a> <span class="divider">/</span></li>
  <li class="active">รายงานผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ 2554-2555 แยกตาม สคร.</li>
</ul>
<div id="container"></div>