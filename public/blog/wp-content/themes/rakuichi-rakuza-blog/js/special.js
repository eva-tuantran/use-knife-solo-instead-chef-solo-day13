var memoryType;
var iphoneChart = {
	show : function(memoryFlg){
		memoryType = memoryFlg;
		this.setStatus(memoryFlg);
		this.change(memoryFlg);
	},
	change : function(memoryFlg){
		var lineData = eval("chartData.iphone" + memoryFlg + ";");
		var options = {renderTo : "iphoneCharts", title : "", unit : "円", lineData : lineData, dateCategorys : dateCategorys};
		this.create(options);
		var items = this.getCompanyColorItems();
		var defaultCompanyColor  = eval("items."+model+"names.i0");
		this.showPrice(defaultCompanyColor);
	},
	showPrice : function(companyColor, objectId){
		if(objectId){
			$("#priceTitle").text($("#"+objectId).text());
		}
		var avgPrice = CommonTools.number_format(eval("aucPriceData.iphone" + memoryType + "."+companyColor+".avgPrice"));
		var price = CommonTools.number_format(eval("aucPriceData.iphone" + memoryType + "."+companyColor+".price"));
		var avgPriceUrl = eval("aucPriceUrlData.iphone" + memoryType + "."+companyColor+".avgPriceUrl");
		if(avgPrice == null || avgPrice == 0) avgPrice = "-";
		if(price == null || price == 0) price = "- ";
		$(".price .bid #avgPrice").text(avgPrice+"円");
		//$(".price .buy #price").text(price+"円");
		$(".price .bid a.desktop_visible").attr("href", avgPriceUrl);
	},
	setStatus : function(memoryFlg){
		var items = this.getMemoryItems();
		var itemNames = eval("items."+model+"names");
		$.each(itemNames, function(key,value){
			$("#btn_"+value).removeClass('system_hide');
			if(value == memoryFlg){
				$("#btn_"+memoryFlg).addClass('active');
			}else{
				$("#btn_"+value).removeClass('active');
			}
		});
		switch (model) {
			case 'iphone4':
				$("#btn_64G").addClass('system_hide');
				$("#btn_sbBla").removeClass('system_hide');
				$("#btn_sbWhi").removeClass('system_hide');
				$("#btn_auBla").addClass('system_hide');
				$("#btn_auWhi").addClass('system_hide');
				break;
			case 'iphone3GS':
				$("#btn_64G").addClass('system_hide');
				$("#btn_8G").addClass('system_hide');
				$("#btn_sbBla").removeClass('system_hide');
				$("#btn_sbWhi").removeClass('system_hide');
				$("#btn_auBla").addClass('system_hide');
				$("#btn_auWhi").addClass('system_hide');
				break;
			case 'iphone3G':
				$("#btn_64G").addClass('system_hide');
				$("#btn_32G").addClass('system_hide');
				$("#btn_sbBla").removeClass('system_hide');
				$("#btn_sbWhi").removeClass('system_hide');
				if(memoryFlg == "8G")$("#btn_sbWhi").addClass('system_hide');
				$("#btn_auBla").addClass('system_hide');
				$("#btn_auWhi").addClass('system_hide');
				break;
			default://iphone4S,iphone5
				$("#btn_sbBla").removeClass('system_hide');
				$("#btn_sbWhi").removeClass('system_hide');
				$("#btn_auBla").removeClass('system_hide');
				$("#btn_auWhi").removeClass('system_hide');
				break;
		}
	},
	getMemoryItems : function(){
		var items = {
			iphone5names  : {'i0':'64G','i1':'32G','i2':'16G'},
			iphone4Snames : {'i0':'64G','i1':'32G','i2':'16G'},
			iphone4names  : {'i0':'32G','i1':'16G','i2':'8G'},
			iphone3GSnames : {'i0':'32G','i1':'16G'},
			iphone3Gnames : {'i0':'16G','i1':'8G'}
		}
		return items;
	},
	getCompanyColorItems : function(){
		var items = {
			iphone5names  : {'i0':'sbBla','i1':'sbWhi','auBla':'auWhi'},
			iphone4Snames : {'i0':'sbBla','i1':'sbWhi','auBla':'auWhi'},
			iphone4names  : {'i0':'sbBla','i1':'sbWhi'},
			iphone3GSnames : {'i0':'sbBla','i1':'sbWhi'},
			iphone3Gnames : {'i0':'sbBla','i1':'sbWhi'}
		}
		return items;
	},
	create : function(options){
		var chart = new Highcharts.Chart({
			chart : {
				renderTo : options.renderTo,
				defaultSeriesType : 'line',
				marginRight: 30,
				marginBottom: 50
			},
			credits : {
				enabled : false
			},

			title : {
				text : '',
				verticalAlign : "bottom",
				y : 10,
				align : "center"
			},
			xAxis: {
                categories: options.dateCategorys
            },
			yAxis : {
				title : {
					text : ""
				},
				min : 0,
				labels : {
					formatter : function() {
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
						return yValue + options.unit;
					}
				},

				plotLines : [ {
					value : 0,
					width : 1
				} ]
			},
			tooltip : {
				formatter : function() {
					var showDate = "日付：" + this.x;
					var showPrice = "価格：" + CommonTools.number_format(this.y) + options.unit;
					return '<b>' + this.series.name + '</b><br/>'
							+ showDate + '<br/>'
							+ showPrice;
				}
			},
			legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                borderWidth: 0
            },
			exporting : {
				enabled : false
			},
			series : options.lineData
		});
	}
};


var CommonTools = {
	number_format : function(number, decimals, dec_point, thousands_sep) {
		if((decimals == null) && !this.isInt(number))
		decimals = 2;
	   var n = !isFinite(+number) ? 0 : +number,   
	       prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),   
	       sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,   
	       dec = (typeof dec_point === 'undefined') ? '.' : dec_point,   
	       s = '',   
	       toFixedFix = function (n, prec){   
	           var k = Math.pow(10, prec);   
	           return '' + Math.round(n * k) / k;        
	           };   
	   s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');   
	   if(s[0].length > 3){   
	       s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	   }   
	   if((s[1] || '').length < prec){   
	       s[1] = s[1] || '';   
	       s[1] += new Array(prec - s[1].length + 1).join('0');   
	   }
	   return s.join(dec);  
	},
	isInt : function(number){
		var reg = /^\d+$/;
		return reg.test(number);
	}
}
