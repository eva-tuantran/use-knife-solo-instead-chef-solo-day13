var chartDataList;
var dateCategorys;
//var durationSpeed = 2000;

jQuery(document).ready(function() {

	jQuery("#dailyChart").ajaxComplete(function() {

		if (chartDataList && dateCategorys) {

			var cnt = chartDataList.length;
			if (cnt == 7) {
				chartDataList.unshift("平均落札額");
				var tmp = dateCategorys;
				var date = [""];
				for (i = 0; i < dateCategorys.length; i++) {
					var tmp = dateCategorys[i];
					date.push(tmp.substring(5, 10));

				}

				var chartdata = {
					"config": {
						"type": "line",
						"lineWidth": "2",
						"unit": "円",
						"useVal": "yes",
						"bg": "#fff",
						"textColor": "#000",
						"xColor": "rgba(100,100,100,0.3)",
						"yColor": "#fff",
						"hanreiXOffset": -230,
						"hanreiYOffset": -33,
						"minY": 0
					},
					"data": [
						date,
						chartDataList
					]
				};
				ccchart.init('dailyChart', chartdata)

				chartDataList.length = 0;
			}
		}
	});
});


function getItemInfo(params) {
	console.debug(params);
	jQuery.ajax({
		type: 'post',
		url: '/aucfan/item.php',
		data: params,
		dataType: 'json',
		success: function(res) {
			var html = "";
			var pull = "";
			for (i = 0; i < res.length; i++) {
				html = html + '<span class="predict_bit_price">' + res[i].avr + '</span>円</div>' +
						'<div style="font-size:14px;"><a href="' + res[i].link + '" target="_blank">&gt;&gt;落札結果一覧を見る</a></div>';
			}
			jQuery("#" + params.block).html(html);
			console.debug('hello');
		},
		error: function(res) {
			console.debug('hellxo');
		}
	});
	console.debug('hellxdd');
}

function getPurchaseInfo(params) {
	jQuery.ajax({
		type: 'post',
		url: '/aucfan/monocheki.php',
		data: params,
		dataType: 'json',
		success: function(res) {
			var html = '';
			if (res.length > 0 && res[0].price != 0) {
				html = '<span class="predict_bit_price">' + res[0].price + '</span>円</div>';
			} else {
				html = '<span class="predict_bit_price">----</span>円</div>';
			}
			html = html + '<div style="font-size:14px;"><a href="https://brandear.jp/request/kit_pt1?pid=6g44ra" target="_blank">&gt;&gt;買取を依頼する</a></div>';
			jQuery("#" + params.block).html(html);
		},
		error: function(res) {
			html = '<span class="predict_bit_price">----</span>円</div>' + '<div style="font-size:14px;"><a href="https://brandear.jp/request/kit_pt1?pid=6g44ra" target="_blank">&gt;&gt;買取を依頼する</a></div>';
			jQuery("#" + params.block).html(html);
		}
	});
}

function loadChartDataList(params) {
	jQuery.ajax({
		type: 'post',
		url: '/aucfan/loadchart.php',
		data: params,
		dataType: 'json',
		success: function(res) {
			loadChartDataListSuccess(res);
		},
		error: function(res) {
		}
	});
}

function loadChartDataListSuccess(data) {
	if (typeof data != "object")
		data = eval(data);
	if (data != null) {
		chartDataList = data.formatChartDataList.dailyChartData.dailyLineChartDataAvgEndPrice;
		dateCategorys = data.formatChartDataList.dailyChartData.dateCategorys;
		jQuery("#dailyChart").html(" ");
	}
	return;


	if (chartDataList != null) {
		if (typeof chartDataList.error_code != "undefined") {
//			if(chartDataList.error_code == "500")
//				isServiceError = true;
			alert(chartDataList.error_message);
			return;
		}
//		if(typeof chartDataList.formatChartDataList.summary.bid_cnt  != "undefined"){
//			n = chartDataList.formatChartDataList.summary.bid_cnt;
//			n = CommonTools.number_format(n);
//		}
//		if(typeof chartDataList.formatChartDataList.summary.avg_end_price  != "undefined"){
//			a = chartDataList.formatChartDataList.summary.avg_end_price;
//			a = CommonTools.number_format(a);
//		}

	}
	if (chartDataList == null || typeof chartDataList.summary.seller_num == "undefined"
			|| chartDataList.summary.seller_num == 0) {
		alert("該当情報が存在しませんでした。");
		return;
	}

	showChart();
}


function showChart(showFlg) {
	var dailyChartData = chartDataList.dailyChartData;

	var dateCategorys = dailyChartData.dateCategorys;
	var lineData;
	if ((showFlg == "dayTotalPrice" || showFlg == null)) {
		lineData = dailyChartData.dailyLineChartDataSumEndPrice;
		var option = {color: "#A66FDD", title: "総落札額", unit: "円", dateCategorys: dateCategorys, lineData: lineData};
	}
	if (showFlg == "dayTotalCount") {
		lineData = dailyChartData.dailyLineChartDataBidCnt;
		var option = {color: "#A66FDD", title: "総落札数", unit: "件", dateCategorys: dateCategorys, lineData: lineData};
	}
	if (showFlg == "dayAveragePrice") {
		lineData = dailyChartData.dailyLineChartDataAvgEndPrice;
		var option = {color: "#A66FDD", title: "平均落札額", unit: "円", dateCategorys: dateCategorys, lineData: lineData};
	}
	if (showFlg == "dayMaxPrice") {
		lineData = dailyChartData.dailyLineChartDataMaxEndPrice;
		var option = {color: "#A66FDD", title: "最高落札額", unit: "円", dateCategorys: dateCategorys, lineData: lineData};
	}
	DayChart.createDayLineChart(option);
}


var DayChart = {
	createDayLineChart: function(option) {
		var now = Date.getJsonDate();
		var chart = new Highcharts.Chart({
			chart: {
				renderTo: "dailyChart",
				defaultSeriesType: 'line',
				zoomType: 'x',
				marginRight: 10,
				marginBottom: 40

			},
			credits: {
				enabled: false
			},
			plotOptions: {
				line: {
					color: option.color
				},
				series: {
					animation: {
						duration: durationSpeed
					}
				}
			},
			title: {
				text: "ネットオークションでの価格動向"
			},
			xAxis: {
				type: 'datetime',
				labels: {
					formatter: function() {
						var nowTime = Date.UTC(now.y, now.m - 1, now.d);
						var count = (this.value - nowTime) / (24 * 3600 * 1000);
						var date = new Date(option.dateCategorys[count]);
						var showValue = (date.getMonth() + 1) + "/" + date.getDate();
						if (date.toString() == 'Invalid Date' || date.toString() == 'NaN') {
							showValue = "";
						}
						return showValue;
					}
				},
				tickmarkPlacement: "on",
				tickPosition: 'inside',
				maxZoom: 7 * 24 * 3600000
			},
			yAxis: {
				title: {
					text: null
				},
				min: 0,
				labels: {
					formatter: function() {
						var yValue = this.value;
						if (this.value / 1000000000000 >= 1) {
							yValue = (this.value / 1000000000000) + '兆';
						} else if (this.value / 100000000 >= 1) {
							yValue = (this.value / 100000000) + '億';
						} else if ((this.value / 10000) >= 1) {
							yValue = (this.value / 10000) + '万';
						} else {
							yValue = CommonTools.number_format(yValue);
						}
						return yValue + option.unit;
					}

				},
				plotLines: [{
						value: 0,
						width: 1,
						color: option.color
					}]
			},
			tooltip: {
				formatter: function() {
					var nowTime = Date.UTC(now.y, now.m - 1, now.d);
					var count = (this.x - nowTime) / (24 * 3600 * 1000);
					var showDate = "日付：" + option.dateCategorys[count];
					return '<b>' + showDate + '</b><br/><b>' + this.series.name + ':</b>' +
							CommonTools.number_format(this.y) + option.unit;
				}
			},
			legend: {
				enabled: false
			},
			exporting: {
				enabled: false
			},
			series: [{
					name: option.title,
					pointInterval: 24 * 3600 * 1000,
					pointStart: Date.UTC(now.y, now.m - 1, now.d),
					data: option.lineData
				}]
		});
	}
}


Date.format = function(strDate, format) {
	var jsonDate;
	if (typeof strDate == "string") {
		if (strDate.indexOf("-") == -1 && strDate.indexOf("/") == -1) {
			strDate = strDate.substring(0, 4) + "/" + strDate.substring(4, 6) + "/" + strDate.substring(6);
		}
		jsonDate = Date.getJsonDate(strDate);
	} else if (typeof strDate == "object") {
		jsonDate = strDate;
	} else {
		alert(strDate + ' is Invalid Date format');
		return null;
	}
	switch (format) {
		case "-" :
			strDate = jsonDate.y + "-" + jsonDate.m + "-" + jsonDate.d;
			break;
		case "/" :
			strDate = jsonDate.y + "/" + jsonDate.m + "/" + jsonDate.d;
			break;
		case "*" :
			strDate = jsonDate.y + "年" + jsonDate.m + "月" + jsonDate.d + "日";
			break;
		default:
			strDate = jsonDate.y + jsonDate.m + jsonDate.d;
			break;
	}
	return strDate;
};
Date.subDay = function(strDate, addDays) {
	var date = new Date(Date.parse(strDate));
	if (date.toString() == 'Invalid Date' || date.toString() == 'NaN') {
		alert(strDate + ' is Invalid Date subDay');
		return null;
	}
	var baseSec = date.getTime();
	var addSec = addDays * 86400000;
	var targetSec = baseSec + addSec;
	date.setTime(targetSec);
	return Date.getJsonDate(date.toString());
};
Date.getJsonDate = function(strDate) {
	var dd;
	if (strDate == null) {
		dd = new Date();
	} else {
		dd = new Date(Date.parse(strDate));
		if (dd.toString() == 'Invalid Date' || dd.toString() == 'NaN') {
			alert(strDate + ' is Invalid Date getJsonDate');
			return null;
		}
	}
	var yy = dd.getYear();
	var mm = dd.getMonth() + 1;
	var dd = dd.getDate();
	if (yy < 2000) {
		yy += 1900;
	}
	if (mm < 10) {
		mm = "0" + mm;
	}
	if (dd < 10) {
		dd = "0" + dd;
	}
	return {y: yy, m: mm, d: dd};
};

var CommonTools = {
	number_format: function(number, decimals, dec_point, thousands_sep) {
		if ((decimals == null) && !this.isInt(number))
			decimals = 2;
		var n = !isFinite(+number) ? 0 : +number,
				prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
				sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
				dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
				s = '',
				toFixedFix = function(n, prec) {
			var k = Math.pow(10, prec);
			return '' + Math.round(n * k) / k;
		};
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	},
	isInt: function(number) {
		var reg = /^\d+$/;
		return reg.test(number);
	}

}

function selectType(typeId, flg) {
	var types = ['iPhone5', 'iPhone4S', 'iPhone4', 'iPhone3GS', 'iPhone3G'];

	var carrierId = getCarrierId(jQuery('#selected_carrier').val());
	var size = jQuery('#selected_size').val();

	checkSelectItems(typeId, carrierId, size, flg);

	for (var i = 0, len = types.length; i < len; i++) {
		jQuery('#img_' + types[i] + ' img').removeClass("active");
	}
	jQuery('#img_' + typeId + ' img').addClass("active");
	jQuery('#selected_type').val(typeId);

	if (typeId === 'iPhone4' || typeId === 'iPhone3G' || typeId === 'iPhone3GS') {
		selectCarrier('sb', flg);
		return;
	}

	if (flg == 'sale') {
		searchSalePrice();
	} else {
		searchBuyPrice();
	}
	return;
}


function selectCarrier(carrierId, flg) {
	var carriers = ['au', 'sb', 'sim'];

	var type = jQuery('#selected_type').val();
	var size = jQuery('#selected_size').val();

	checkSelectItems(type, carrierId, size, flg);

	for (var i = 0, len = carriers.length; i < len; i++) {
		jQuery('#carrier_' + carriers[i] + ' div').removeClass("active");
	}

	jQuery('#carrier_' + carrierId + ' div').addClass("active");

	var carrierVal = '';
	if (carrierId === 'sb') {
		carrierVal = 'SoftBank';
	} else if (carrierId === 'sim') {
		carrierVal = 'SIMフリー';
	} else {
		carrierVal = carrierId;
	}
	jQuery('#selected_carrier').val(carrierVal);

	if (flg == 'sale') {
		searchSalePrice();
	} else {
		searchBuyPrice();
	}
	return;
}

function selectSize(sizeId, flg) {
	var size = ['64G', '32G', '16G', '8G'];

	var type = jQuery('#selected_type').val();
	var carrierId = getCarrierId(jQuery('#selected_carrier').val());

	checkSelectItems(type, carrierId, sizeId, flg);

	for (var i = 0, len = size.length; i < len; i++) {
		jQuery('#size_' + size[i] + ' div').removeClass("active");
	}
	jQuery('#size_' + sizeId + ' div').addClass("active");
	jQuery('#selected_size').val(sizeId);

	if (flg == 'sale') {
		searchSalePrice();
	} else {
		searchBuyPrice();
	}
	return;
}

function checkSelectItems(type, carrierId, size, flg) {
	if (type === 'iPhone3G') {
		if (carrierId != 'sb') {
			jQuery('#selected_carrier').val('SoftBank');
			jQuery('#selected_size').val('16G');
			selectSize('16G', flg);
		}
		jQuery('#display_carrier_au').css("visibility", "hidden");
		jQuery('#display_carrier_sim').css("visibility", "hidden");
		jQuery('#display_size_64G').css("visibility", "hidden");
		jQuery('#display_size_32G').css("visibility", "hidden");
		jQuery('#display_size_16G').css("visibility", "visible");
		jQuery('#display_size_8G').css("visibility", "visible");

		return;

	} else if (type === 'iPhone3GS') {
		if (carrierId != 'sb') {
			jQuery('#selected_carrier').val('SoftBank');
			jQuery('#selected_size').val('32G');
			selectSize('32G', flg);
		}
		jQuery('#display_carrier_au').css("visibility", "hidden");
		jQuery('#display_carrier_sim').css("visibility", "hidden");
		jQuery('#display_size_64G').css("visibility", "hidden");
		jQuery('#display_size_32G').css("visibility", "visible");
		jQuery('#display_size_16G').css("visibility", "visible");
		jQuery('#display_size_8G').css("visibility", "hidden");

		return;

	} else if (type === 'iPhone4') {
		if (carrierId === 'au') {
			jQuery('#selected_carrier').val('SoftBank');
			jQuery('#selected_size').val('32G');
			selectSize('32G', flg);
		} else if (carrierId === 'sb') {
			jQuery('#display_size_64G').css("visibility", "hidden");
			jQuery('#display_size_32G').css("visibility", "visible");
			jQuery('#display_size_16G').css("visibility", "visible");
			jQuery('#display_size_8G').css("visibility", "visible");

		} else if (carrierId === 'sim') {
			jQuery('#display_size_64G').css("visibility", "hidden");
			jQuery('#display_size_32G').css("visibility", "visible");
			jQuery('#display_size_16G').css("visibility", "visible");
			jQuery('#display_size_8G').css("visibility", "hidden");
		}

		jQuery('#display_carrier_au').css("visibility", "hidden");
		jQuery('#display_carrier_sim').css("visibility", "visible");

		return;

	} else if (type === 'iPhone4S' || type === 'iPhone5') {
		if (size === '8G') {
			jQuery('#selected_size').val('64G');
			selectSize('64G', flg);
		}
		jQuery('#display_carrier_au').css("visibility", "visible");
		jQuery('#display_size_64G').css("visibility", "visible");
		jQuery('#display_size_32G').css("visibility", "visible");
		jQuery('#display_size_16G').css("visibility", "visible");
		jQuery('#display_size_8G').css("visibility", "hidden");
	}

	return true;
}


function setTradePrice(key, title) {
	title = title + 'の下取り価格';

	jQuery("#trade_price").html(tradePrice[key]);
	jQuery("#trade_price_title").html(title);

	return;
}

function getCarrierId(carrierName) {
	var carrierId = '';
	if (carrierName === 'SIMフリー') {
		carrierId = 'sim';
	} else if (carrierName === 'SoftBank') {
		carrierId = 'sb';
	} else {
		carrierId = carrierName;
	}

	return carrierId;

}


function searchSalePrice() {
	var type = jQuery('#selected_type').val();
	var carrier = jQuery('#selected_carrier').val();
	var size = jQuery('#selected_size').val();
	var imagePath = '<img src="/wp-content/uploads/2013/09/' + type + '.png">';

	jQuery("#view_type").html(type);
	jQuery("#selected_name").html(type);
	jQuery("#view_carrier").html(carrier);
	jQuery("#view_size").html(size);
	jQuery("#view_image").html(imagePath);

	var carrierKey = getCarrierId(carrier);
	var key = type + '_' + carrierKey + '_' + size;

	// 下取り価格表示
	setTradePrice(key, carrier);

	// monocheki取得
	var modelId = String(modelIdList[key]);

	var purchaseParams = {"data": [{"modelId": modelId}], "block": "purchase_price"};
	getPurchaseInfo(purchaseParams);

	// auction
	var tmpParams = itemConditions[key];
	var itemParams = {"data": [{"name": tmpParams[0]['name'], "q": tmpParams[0]['q'], "nq": tmpParams[0]['nq'], "price_begin": tmpParams[0]['price_begin'], "price_end": tmpParams[0]['price_end'], "img": tmpParams[0]['img']}
		], "block": "auction_price"};
	getItemInfo(itemParams);

	// chart
	var keyword = encodeURIComponent(tmpParams[0]['q']);
	var exword = encodeURIComponent(tmpParams[0]['nq']);
	var chartParams = {"data": [{"keyword": keyword, "exword": exword, "min_price": tmpParams[0]['price_begin'], "max_price": tmpParams[0]['price_end']}
		], "block": "chart_area"};
	loadChartDataList(chartParams);
}

function searchBuyPrice() {
	var type = jQuery('#selected_type').val();
	var carrier = jQuery('#selected_carrier').val();
	var size = jQuery('#selected_size').val();
	var imagePath = '<img src="/wp-content/uploads/2013/09/' + type + '.png">';

	jQuery("#view_type").html(type);
	jQuery("#selected_name").html(type);
	jQuery("#view_carrier").html(carrier);
	jQuery("#view_size").html(size);
	jQuery("#view_image").html(imagePath);

	var carrierKey = getCarrierId(carrier);
	var key = type + '_' + carrierKey + '_' + size;


	var tmpParams = itemConditions[key];
	var keyword = encodeURIComponent(tmpParams[0]['q']);
	var exword = encodeURIComponent(tmpParams[0]['nq']);

	// global link
	var globalUrl = "http://global.aucfan.com/search/list?q=";
	if (navigator.userAgent.indexOf('iPhone') > 0 || navigator.userAgent.indexOf('iPad') > 0 
		|| navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0)
	{
		globalUrl = "http://global.aucfan.com/sp/search/list?q=";
	}
	
	var html = '<a href="' + globalUrl + keyword + '" class="btn btn-large btn-warning" target="_blank">世界各国の価格を比較する<br /><img src="/wp-content/uploads/2013/09/flag.png"></a>';
	jQuery("#global_aucfan").html(html);


	// shopping
	var newParams = {"data": [{"q": tmpParams[0]['q'], "nq": tmpParams[0]['exq'], "price_begin": tmpParams[0]['price_begin'], "price_end": tmpParams[0]['price_end'], "search_type": "new"}
		], "block": "new_price"};
	getItemAverage(newParams);

//	// auction
	var aucParams = {"data": [{"q": tmpParams[0]['q'], "nq": tmpParams[0]['exq'], "price_begin": tmpParams[0]['price_begin'], "price_end": tmpParams[0]['price_end'], "search_type": "auc"}
		], "block": "auction_price"};
	getItemAverage(aucParams);

	// chart
	var chartParams = {"data": [{"keyword": keyword, "exword": exword, "min_price": tmpParams[0]['price_begin'], "max_price": tmpParams[0]['price_end']}
		], "block": "chart_area"};
	loadChartDataList(chartParams);
}


function getItemAverage(params) {
	jQuery.ajax({
		type: 'post',
		url: '/aucfan/average.php',
		data: params,
		dataType: 'json',
		success: function(res) {
			var html = "";
			var pull = "";

			if (params.data[0].search_type == 'new') {
				html = html + '<span class="predict_bit_price">' + res.price + '</span>円</div>' +
						'<div style="font-size:14px;"><a href="' + res.link + '" target="_blank">&gt;&gt;新品価格一覧を見る</a></div>';
			} else {
				html = html + '<span class="predict_bit_price">' + res.price + '</span>円</div>' +
						'<div style="font-size:14px;"><a href="' + res.link + '" target="_blank">&gt;&gt;オークション価格一覧を見る</a></div>';
			}
			jQuery("#" + params.block).html(html);
		},
		error: function(res) {
		}
	});
}
