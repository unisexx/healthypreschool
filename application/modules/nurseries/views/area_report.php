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
                text: 'ผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ 2554-2555 (สคร.<?=$area_id?>)',
                x: -20 //center
            },
            subtitle: {
                text: ' ',
                x: -20
            },
            xAxis: {
                categories: [
                	<?php foreach($provinces as $province):?>
                	'<a href="nurseries/province_report/<?=$province->id?>"><?=$province->name?></a>',
                	<?php endforeach;?>
                ]
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
            series: [
            {
                name: 'จำนวนศูนย์เด็กเล็กที่เข้าร่วมโครงการ (แห่ง)',
                data:[
                		<?php 
	                		foreach($provinces as $key=>$province){
	                			$nursery[$key] = new Nursery();
								$nursery[$key]->select("COUNT(province_id) AS regis_count")->where("province_id = ".$province->id)->get();
								echo $nursery[$key]->regis_count.',';
	                		}
						?>
				]
            },
            {
                name: 'จำนวนศูนย์เด็กเล็กที่ผ่านเกณฑ์ (แห่ง)',
                data:[
                		<?php 
	                		foreach($provinces as $key=>$province){
	                			$nursery[$key] = new Nursery();
								$nursery[$key]->select("COUNT(province_id) AS regis_count")->where("province_id = ".$province->id." and status = 1")->get();
								echo $nursery[$key]->regis_count.',';
	                		}
						?>
				]
            },
            {
                name: 'จำนวนศูนย์เด็กเล็กที่ไม่ผ่านเกณฑ์ (แห่ง)',
                data:[
                		<?php 
	                		foreach($provinces as $key=>$province){
	                			$nursery[$key] = new Nursery();
								$nursery[$key]->select("COUNT(province_id) AS regis_count")->where("province_id = ".$province->id." and status = 0")->get();
								echo $nursery[$key]->regis_count.',';
	                		}
						?>
				]
            }
            ]
        });
    });
});
</script>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="nurseries">ศูนย์เด็กเล็กปลอดโรค</a> <span class="divider">/</span></li>
  <li class="active">รายงานผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ 2554-2555 (สคร.<?=$area_id?>)</li>
</ul>
<div id="container"></div>