<!DOCTYPE html>
<html>
<head>
	<title>Market Depth Chart</title>
</head>
<body style="background-color:#fff">
	<div id="marketchartdiv1" style="height: 300px;"></div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script src="https://www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js"></script>  
	<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
	<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
	<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

	<!-- market Chart code -->
	<script>		
		var chart = AmCharts.makeChart("marketchartdiv1", {
			"type": "serial",
			"theme": "light",
			"data": {
				"_token": "{{ csrf_token() }}",
				"marketpair": $('#marketpair').val()

			},
			"dataLoader": {
				"url": "{{ url('marketdepthchart/'.$pair) }}",
				"type": "POST",
				"format": "json",
				"reload": 30,
				"postProcess": function(data) {

				// Function to process (sort and calculate cummulative volume)
				function processData(list, type, desc) {
					
					// Convert to data points
					for(var i = 0; i < list.length; i++) {
						list[i] = {
							value: Number(list[i][0]),
							volume: Number(list[i][1]),
						}
					}
					
					// Sort list just in case
					list.sort(function(a, b) {
						if (a.value > b.value) {
							return 1;
						}
						else if (a.value < b.value) {
							return -1;
						}
						else {
							return 0;
						}
					});
					
					// Calculate cummulative volume
					if (desc) {
						for(var i = list.length - 1; i >= 0; i--) {
							if (i < (list.length - 1)) {
								list[i].totalvolume = list[i+1].totalvolume + list[i].volume;
							}
							else {
								list[i].totalvolume = list[i].volume;
							}
							var dp = {};
							dp["value"] = list[i].value;
							dp[type + "volume"] = list[i].volume;
							dp[type + "totalvolume"] = list[i].totalvolume;
							res.unshift(dp);
						}
					}
					else {
						for(var i = 0; i < list.length; i++) {
							if (i > 0) {
								list[i].totalvolume = list[i-1].totalvolume + list[i].volume;
							}
							else {
								list[i].totalvolume = list[i].volume;
							}
							var dp = {};
							dp["value"] = list[i].value;
							dp[type + "volume"] = list[i].volume;
							dp[type + "totalvolume"] = list[i].totalvolume;
							res.push(dp);
						}
					}
					
				}
				
				// Init
				var res = [];
				processData(data.bids, "bids", true);
				processData(data.asks, "asks", false);
				
				//console.log(res);
				return res;
			}
		},
		"graphs": [{
			"id": "bids",
			"fillAlphas": 0.1,
			"lineAlpha": 1,
			"lineThickness": 2,
			"lineColor": "#0f0",
			"type": "step",
			"valueField": "bidstotalvolume",
			"balloonFunction": balloon
		}, {
			"id": "asks",
			"fillAlphas": 0.1,
			"lineAlpha": 1,
			"lineThickness": 2,
			"lineColor": "#f00",
			"type": "step",
			"valueField": "askstotalvolume",
			"balloonFunction": balloon
		}, {
			"lineAlpha": 0,
			"fillAlphas": 0.2,
			"lineColor": "#000",
			"type": "column",
			"clustered": false,
			"valueField": "bidsvolume",
			"showBalloon": false
		}, {
			"lineAlpha": 0,
			"fillAlphas": 0.2,
			"lineColor": "#000",
			"type": "column",
			"clustered": false,
			"valueField": "asksvolume",
			"showBalloon": false
		}],
		"categoryField": "value",
		"chartCursor": {},
		"balloon": {
			"textAlign": "left"
		},
		"valueAxes": [{
			"title": "Volume"
		}],
		"categoryAxis": {
			"title": "Price ({{ $coinone }}{{ '/' }}{{ $cointwo }})",
			"minHorizontalGap": 100,
			"startOnAxis": true,
			"showFirstLabel": false,
			"showLastLabel": false
		},
		"export": {
			"enabled": true
		}
	});
	function balloon(item, graph) {
		var txt;
		if (graph.id == "asks") {
			txt = "Ask: <strong>" + formatNumber(item.dataContext.value, graph.chart, 4) + "</strong><br />"
			+ "Total volume: <strong>" + formatNumber(item.dataContext.askstotalvolume, graph.chart, 4) + "</strong><br />"
			+ "Volume: <strong>" + formatNumber(item.dataContext.asksvolume, graph.chart, 4) + "</strong>";
		}
		else {
			txt = "Bid: <strong>" + formatNumber(item.dataContext.value, graph.chart, 4) + "</strong><br />"
			+ "Total volume: <strong>" + formatNumber(item.dataContext.bidstotalvolume, graph.chart, 4) + "</strong><br />"
			+ "Volume: <strong>" + formatNumber(item.dataContext.bidsvolume, graph.chart, 4) + "</strong>";
		}
		return txt;
	}

	function formatNumber(val, chart, precision) {
		return AmCharts.formatNumber(
			val, 
			{
				precision: precision ? precision : chart.precision, 
				decimalSeparator: chart.decimalSeparator,
				thousandsSeparator: chart.thousandsSeparator
			}
			);
	}
	</script>
</body>
</html>