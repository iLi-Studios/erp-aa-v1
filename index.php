<?php 
include"ili-functions/functions.php";
Authorization('2');
function Statistique($query, $result_type){
	$o=QueryExcute("mysqli_fetch_array", $query);
	if($result_type=='number'){
		echo $o[0];
	}
	if($result_type=='currency'){
		printf('%0.3f', $o[0]);
	}
}
function CreditChart(){
	$i=0;$j=0;
	for ($i=01;$i<=31;$i++){
		if($i<10){$date= '0'.$i.date("-m-Y");}else{$date= date("Y-m-").$i;}
		$q="SELECT SUM(`Amount`) FROM `payment` WHERE `EncashmentDate`='$date' AND `Amount` > 0";
		$r=QueryExcuteWhile($q);
		while ($o=mysqli_fetch_array($r)){
			echo '['.$i.', ';?><?php if($o[0]){echo $o[0].'],';}else{echo '0],';}
		}
	}
}
function DebitChart(){
	$i=0;$j=0;
	for ($i=01;$i<=31;$i++){
		if($i<10){$date= '0'.$i.date("-m-Y");}else{$date= date("Y-m-").$i;}
		$r=QueryExcuteWhile("SELECT SUM(`Amount`) FROM `payment` WHERE `EncashmentDate`='$date' AND `Amount` < 0");
		while ($o=mysqli_fetch_array($r)){
			echo '['.$i.', ';?><?php if($o[0]){echo -$o[0].'],';}else{echo '0],';}
		}
	}
}
?>
<!DOCTYPE html>
<?php echo $author; ?>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="fr">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8" />
<title><?php echo $sytem_title;?></title>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta content="iLi-ERP" name="description" />
<link rel="icon" href="ili-upload/favicon.png" type="image/x-icon" />
<meta content="SAKLY AYOUB" name="author" />
<link href="ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="ili-style/css/style.css" rel="stylesheet" />
<link href="ili-style/css/style_responsive.css" rel="stylesheet" />
<link href="ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
<link href="ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="ili-style/assets/uniform/css/uniform.default.css" />
<link href="ili-style/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
<link href="ili-style/assets/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
<?php include"ili-functions/fragments/page_header.php";?>
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid">
	<?php include"ili-functions/fragments/sidebar.php";?>
	<!-- BEGIN PAGE -->
	<div id="main-content"> 
		<!-- BEGIN PAGE CONTAINER-->
		<div class="container-fluid"> 
			<!-- BEGIN PAGE HEADER-->
			<div class="row-fluid">
				<div class="span12"> 
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title"> Dashboard <small> Informations Générales </small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $URL ; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="<?php echo $URL ; ?>">Dashboard</a><span class="divider-last">&nbsp;</span></li>
						<li class="pull-right search-wrap">
							<form class="hidden-phone">
								<div class="search-input-area">
									<input id=" " class="search-query" type="text" placeholder="Search">
									<i class="icon-search"></i> </div>
							</form>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB--> 
				</div>
			</div>
			<!-- END PAGE HEADER--> 
			<!-- BEGIN PAGE CONTENT-->
			<div id="page" class="dashboard">
				<?php ErrorGet('message'); ?>
				<!-- BEGIN OVERVIEW STATISTIC BARS-->
				<div class="row-fluid circle-state-overview">
					<div class="span2 responsive clearfix" data-tablet="span3" data-desktop="span2"> <a href="ili-modules/client/liste">
						<div class="circle-wrap">
							<div class="stats-circle turquoise-color"> <i class="icon-user"></i> </div>
							<p> <strong>
								<?php Statistique("SELECT COUNT('idClient') FROM `client`", "number");?>
								</strong> Clients </p>
						</div>
						</a> </div>
					<div class="span2 responsive" data-tablet="span3" data-desktop="span2"> <a href="ili-modules/contrat/liste">
						<div class="circle-wrap">
							<div class="stats-circle red-color"> <i class="icon-file"></i> </div>
							<p> <strong>
								<?php Statistique("SELECT COUNT('idContract') FROM `insurancecontract`", "number");?>
								</strong> Contrat </p>
						</div>
						</a> </div>
					<div class="span2 responsive" data-tablet="span3" data-desktop="span2">
						<div class="circle-wrap"> <a href="">
							<div class="stats-circle green-color"> <i class="icon-copy"></i> </div>
							<p> <strong>
								ND
								</strong> Renouvellement </p>
							</a> </div>
					</div>
					<div class="span2 responsive" data-tablet="span3" data-desktop="span2">
						<div class="circle-wrap">
							<div class="stats-circle purple-color"> <i class="icon-money"></i> </div>
							<p> <strong>
								<?php Statistique("SELECT SUM(`Amount`) FROM `payment`", "currency");?>
								</strong> Fond </p>
						</div>
					</div>
					<div class="span2 responsive" data-tablet="span3" data-desktop="span2"> <a href="ili-messages/inbox">
						<div class="circle-wrap">
							<div class="stats-circle gray-color"> <i class="icon-comments-alt"></i> </div>
							<p> <strong>
								<?php StatisticMessageGetSum(); ?>
								</strong> Message </p>
						</a></div>
					</div>
					<div class="span2 responsive" data-tablet="span3" data-desktop="span2">
						<div class="circle-wrap">
							<div class="stats-circle blue-color"> <i class="icon-bar-chart"></i> </div>
							<p> <strong>
								<?php StatisticLogGetSum(); ?>
								</strong> Logs Système </p>
						</div>
					</div>
				</div>
				<!-- END OVERVIEW STATISTIC BARS-->
				<div class="row-fluid">
					<div class="span12"> 
						<!-- BEGIN MAILBOX PORTLET-->
						<div class="widget">
							<div class="widget-title">
								<h4><i class="icon-envelope"></i> Messagerie <small> | Les 5 derniers messages</small></h4>
								<span class="tools"> <a href="ili-messages/start" class="icon-plus tooltips" data-original-title="Nouveau Message"> </a> <a href="javascript:;" class="icon-chevron-down"></a> </span> </div>
							<div class="widget-body">
								<table style="width:100%; text-align:left;">
									<thead>
										<tr>
											<th></th>
											<th> Envoyé par </th>
											<th> Sujet </th>
											<th> Etat </th>
											<th> Date </th>
										</tr>
									</thead>
<script type="text/javascript"> 
var auto_refresh = setInterval(function(){$('#loadmessages').load('<?php echo $URL;?>ili-functions/AJAX/MessageGetAll.php').fadeIn("slow");}, 1000); 
// refreshing after every 15000 milliseconds 
</script>
									<tbody id="loadmessages">
									</tbody>
								</table>
							</div>
						</div>
						<!-- END MAILBOX PORTLET--> 
					</div>
				</div>
				<div class="row-fluid">
					<div class="span8"> 
						<!-- BEGIN SITE VISITS PORTLET-->
						<div class="widget">
							<div class="widget-title">
								<h4><i class="icon-bar-chart"></i> Journal du caisse</h4>
								<span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a></span> </div>
							<div class="widget-body">
								<div id="site_statistics_loading"> <img src="ili-style/img/loading.gif" alt="loading" /> </div>
								<div id="site_statistics_content" class="hide">
									<div id="site_statistics" class="chart"></div>
								</div>
							</div>
						</div>
						<!-- END SITE VISITS PORTLET--> 
					</div>
					<div class="span4"> 
						<!-- BEGIN NOTIFICATIONS PORTLET-->
						<div class="widget">
							<div class="widget-title">
								<h4><i class="icon-bell"></i> Notifications</h4>
								<span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a> </span> </div>
							<div class="widget-body">
								<ul class="item-list scroller padding" data-height="300" data-always-visible="1">
									<?php NotifGetAll();?>
								</ul>
							</div>
						</div>
						<!-- END NOTIFICATIONS PORTLET--> 
					</div>
				</div>
				<!--<div class="row-fluid">
					<div class="span12">
						<div class="widget">
							<div class="widget-title">
								<h4><i class="icon-umbrella"></i> Bénifices net en TND</h4>
								<span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a> <a href="javascript:;" class="icon-remove"></a> </span> </div>
							<div class="widget-body">
								<div id="load_statistics_loading"> <img src="ili-style/img/loading.gif" alt="loading" /> </div>
								<div id="load_statistics_content" class="hide">
									<div id="load_statistics" class="chart"></div>
									<div class="btn-toolbar no-bottom-space clearfix"> </div>
								</div>
							</div>
						</div>
					</div>
				</div>-->
			</div>
			<!-- END PAGE CONTENT--> 
		</div>
		<!-- END PAGE CONTAINER--> 
	</div>
	<!-- END PAGE --> 
</div>
<!-- END CONTAINER --> 
<!-- BEGIN FOOTER -->
<div id="footer"><?php echo $copy_right;?>
	<div class="span pull-right"> <span class="go-top"><i class="icon-arrow-up"></i></span> </div>
</div>
<!-- END FOOTER --> 
<!-- BEGIN JAVASCRIPTS --> 
<!-- Load javascripts at bottom, this will reduce page load time --> 
<script src="ili-style/js/jquery-1.8.3.min.js"></script> 
<script src="ili-style/assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script> 
<script src="ili-style/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
<script src="ili-style/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script> 
<script src="ili-style/assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="ili-style/js/jquery.blockui.js"></script> 
<script src="ili-style/js/jquery.cookie.js"></script> 
<!-- ie8 fixes --> 
<!--[if lt IE 9]>
        <script src="js/excanvas.js"></script>
        <script src="js/respond.js"></script>
        <![endif]--> 
<script src="ili-style/assets/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script> 
<script src="ili-style/assets/jquery-knob/js/jquery.knob.js"></script> 
<script src="ili-style/assets/flot/jquery.flot.js"></script> 
<script src="ili-style/assets/flot/jquery.flot.resize.js"></script> 
<script src="ili-style/assets/flot/jquery.flot.pie.js"></script> 
<script src="ili-style/assets/flot/jquery.flot.stack.js"></script> 
<script src="ili-style/assets/flot/jquery.flot.crosshair.js"></script> 
<script src="ili-style/js/jquery.peity.min.js"></script> 
<script type="text/javascript" src="ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script type="text/javascript" src="ili-style/assets/data-tables/jquery.dataTables.js"></script> 
<script type="text/javascript" src="ili-style/assets/data-tables/DT_bootstrap.js"></script> 
<script src="ili-style/js/scripts.js"></script> 
<script>
            jQuery(document).ready(function() {
                // initiate layout and plugins
                App.setMainPage(true);
                App.init();
            });
        </script>
<script>
	var handleDashboardCharts = function () {

        // used by plot functions
        var data = [];
        var totalPoints = 200;

        // random data generator for plot charts
        function getRandomData() {
            if (data.length > 0) data = data.slice(1);
            // do a random walk
            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50;
                var y = prev + Math.random() * 10 - 5;
                if (y < 0) y = 0;
                if (y > 100) y = 100;
                data.push(y);
            }
            // zip the generated y values with the x values
            var res = [];
            for (var i = 0; i < data.length; ++i) res.push([i, data[i]])
            return res;
        }

        if (!jQuery.plot) {
            return;
        }

        function randValue() {
            return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
        }

        var credit = [<?php CreditChart();?>];
        var debit = [<?php DebitChart();?>];

        $('#site_statistics_loading').hide();
        $('#site_statistics_content').show();

        var plot = $.plot($("#site_statistics"), [{
            data: credit,
            label: "Crédit"
        }, {
            data: debit,
            label: "Débit"
        }], {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.05
                        }, {
                            opacity: 0.01
                        }]
                    }
                },
                points: {
                    show: true
                },
                shadowSize: 2
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#eee",
                borderWidth: 0
            },
            colors: ["#A5D16C", "#FCB322", "#32C2CD"],
            xaxis: {
                ticks: 11,
                tickDecimals: 0
            },
            yaxis: {
                ticks: 11,
                tickDecimals: 0
            }
        });


        function showTooltip(x, y, contents) {
            $('<div id="tooltip">' + contents + '</div>').css({
                position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 15,
                border: '1px solid #333',
                padding: '4px',
                color: '#fff',
                'border-radius': '3px',
                'background-color': '#333',
                opacity: 0.80
            }).appendTo("body").fadeIn(200);
        }

        var previousPoint = null;
        $("#site_statistics").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(0));
            $("#y").text(pos.y.toFixed(3));

            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1].toFixed(3);

                    showTooltip(item.pageX, item.pageY, item.series.label + " du " + x + " = " + y + " TND");
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });

        //server load
       /*var options = {
            series: {
                shadowSize: 1
            },
            lines: {
                show: true,
                lineWidth: 0.5,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.1
                    }, {
                        opacity: 1
                    }]
                }
            },
            yaxis: {
                min: 0,
                max: 100,
                tickFormatter: function (v) {
                    return v + "%";
                }
            },
            xaxis: {
                show: false
            },
            colors: ["#A5D16C"],
            grid: {
                tickColor: "#eaeaea",
                borderWidth: 0
            }
        };

        $('#load_statistics_loading').hide();
        $('#load_statistics_content').show();

        var updateInterval = 30;
        var plot = $.plot($("#load_statistics"), [getRandomData()], options);

        function update() {
            plot.setData([getRandomData()]);
            plot.draw();
            setTimeout(update, updateInterval);
        }
        update();*/
    }
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

