@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js" integrity="sha256-XF29CBwU1MWLaGEnsELogU6Y6rcc5nCkhhx89nFMIDQ=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.tutorialjinni.com/jquery-csv/1.0.11/jquery.csv.min.js"></script>
    <script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

	<style>
		.bg-black-alt  {
			background:#161616;
		}
		.text-black-alt  {
			color:#191919;
		}
		.border-black-alt {
			border-color: #191919;
		}
        #chartdiv {
        width: 100%;
        height: 700px;
        }

	</style>

</head>

<body class="bg-RFM-Black font-sans leading-normal tracking-normal">

        <script>
                /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
            var prevScrollpos = window.pageYOffset;
            window.onscroll = function() {
            var currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                document.getElementById("header").style.top = "0";
            } else {
                document.getElementById("header").style.top = "-150px";
            }
            prevScrollpos = currentScrollPos;
            }



            let array = [];
                            let arr = JSON.parse({!! json_encode($data) !!});
                            arr.forEach((current)=>{
                                newArray = {
                                    x: current['frequency'],
                                    y: current['recency'],
                                    r: 2,
                                    clientID: current['customer_id'],
                                    clientStatus: current['segment'],
                                    totalRevenue: current['monetary'],
                                    color: "##F10051",
                                 }
                                array.push(newArray)
                            })


                            Array.prototype.sum = function (prop) {
                            var sum = 0
                            for ( var i = 0, _len = this.length; i < _len; i++ ) {
                                sum += this[i][prop]
                            }
                            return sum
                        }

                        total = array.sum("totalRevenue")
                        let newCustomers = 0;
                        for (let i = 0; i < array.length; i++) {
                        if (array[i].clientStatus == 'New Customers') newCustomers++;
                        }

                        let list = [];
                        let downloadArr = JSON.parse({!! json_encode($data) !!});
                        downloadArr.forEach((old)=>{
                                secArray = {
                                    customer_id: old['customer_id'],
                                    recency: old['recency'],
                                    frequency: old['frequency'],
                                    monetary: old['monetary'],
                                    recency_score: old['recency_score'],
                                    frequency_score: old['frequency_score'],
                                    monetary_score: old['monetary_score'],
                                    rfm_score: old['rfm_score'],
                                    segment: old['segment']

                                 }
                                list.push(secArray)
                            })



        </script>
        <nav id="header" class="bg-RFM-Black fixed w-full z-10 top-0 shadow">


		<div class="w-full container mx-auto flex flex-wrap items-center mt-0 pt-3 pb-3 md:pb-0">
			<div class="w-1/2 pl-2 md:pl-0">
            <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 bg-RFM-Black z-20" id="nav-content">
				<ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0">
					<li class="mr-6 my-2 md:my-0">
                        <a href="{{ url('/') }}" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-RFM-Pink">
                            <i class="fas fa-home fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Home</span>
                        </a>
                    </li>
                    @if (Laratrust::hasRole('admin'))
                    @auth
					<li class="mr-6 my-2 md:my-0">
                        <a href="#"  onclick="window.location.href='/edit-users'" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-RFM-Pink">
                            <i class="fas fa-tasks fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Edit Roles and Permissions</span>
                        </a>
                    </li>
                    @endauth
                    @endif
				</ul>
			</div>
            </div>
			<div class="w-1/2 pr-0">
				<div class="flex relative inline-block float-right">
                @if (Route::has('login'))
                <div class="space-x-4">
                    @auth
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="w-full bg-gradient-to-br from-RFM-Pink to-RFM-Orange hover:text-RFM-Black border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-RFM-Pink_hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500">Log out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    @endauth
                </div>
                 @endif
			</div>




		</div>
	</nav>



	<!--Container-->
	<div class="container w-full mx-auto pt-20">

		<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

			<!--Console Content-->

			<div class="flex flex-wrap">
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3"><i class="fas fa-wallet" style="font-size:30px; color:gray"></i></div>
                            </div>

                            <div class="flex-1 text-right md:text-center">
                                <h5 class="text-base font-extrabold text-2xl text-gray-400">Total Revenue</h5>
                                <h3 id="total" class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">&euro;<script>document.write( Math.ceil(total))</script><span class="text-green-500"><i class="fas fa-caret-up"></i></span></h3>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3"><i class="fas fa-users" style="font-size:30px; color:gray"></i></div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h5 class="text-base font-extrabold text-2xl text-gray-400">Total Customers</h5>
                                <h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange"><script>document.write(array.length)</script> <span class="text-pink-500"><i class="fas fa-exchange-alt"></i></span></h3>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3"><i class="fas fa-user-plus"style="font-size:30px; color:gray"></i></div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h5 class="text-base font-extrabold text-2xl text-gray-400">New Customers</h5>
                                <h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange"><script>document.write(newCustomers)</script> <span class="text-green-600"><i class="fas fa-caret-up"></i></span></h3>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>

            </div>
<!--
            <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black"> -->

			<!--Divider-->

			<div class="bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange my-8 mx-4"></div>



            <div class="w-full" style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
            <!-- <button onclick="xlsDownload();" id="download" class="mr-4 bg-gradient-to-br from-RFM-Pink to-RFM-Orange hover:text-RFM-Black border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-RFM-Black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500">Download xslx RFM Overview</button> -->
            <button onclick="csvDownload();" id="download" class="mr-4 bg-gradient-to-br from-RFM-Pink to-RFM-Orange hover:text-RFM-Black border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-base font-medium text-gray-200 hover:bg-RFM-Black">Download RFM Overview</button>
            </div>
            <!-- <script>
                function xlsDownload()
                {
                     // Convert to xlsx
                    var createXLSLFormatObj = [];

                    /* XLS Head Columns */
                    var xlsHeader = ["customer_id", "recency", "frequency", "monetary", "recency_score", "frequency_score", "monetary_score", "rfm_score", "segment"];

                    /* XLS Rows Data */
                    var xlsRows = Object.values(list);


                    createXLSLFormatObj.push(xlsHeader);
                    $.each(xlsRows, function(index, value) {
                        var innerRowData = [];
                        $("tbody").append('<tr><td>' + value.EmployeeID + '</td><td>' + value.FullName + '</td></tr>');
                        $.each(value, function(ind, val) {

                            innerRowData.push(val);
                        });
                        createXLSLFormatObj.push(innerRowData);
                    });


                    /* File Name */
                    var filename = "RFM_Export.xlsx";

                    /* Sheet Name */
                    var ws_name = "RFM Results";

                    if (typeof console !== 'undefined') console.log(new Date());
                    var wb = XLSX.utils.book_new(),
                        ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj);

                    /* Add worksheet to workbook */
                    XLSX.utils.book_append_sheet(wb, ws, ws_name);

                    /* Write workbook and Download */
                    if (typeof console !== 'undefined') console.log(new Date());
                    XLSX.writeFile(wb, filename);
                    if (typeof console !== 'undefined') console.log(new Date());
                }
            </script> -->



            <script>
                // Convert to csv
                function csvDownload() {
                    const csv = $.csv.fromObjects(list);

                // Download file as csv function
                const downloadBlobAsFile = function(csv, filename){
                    var downloadLink = document.createElement("a");
                    var blob = new Blob([csv], { type: 'text/csv' });
                    var url = URL.createObjectURL(blob);
                    downloadLink.href = url;
                    downloadLink.download = filename;
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                }

                // Download csv file
                downloadBlobAsFile(csv, 'RFM_Export.csv');
                }
          </script>








            <div class="flex flex-row flex-wrap flex-grow mt-2">
                <!-- <div class="w-full p-3"> -->
                    <!--Graph Card-->
                    <!-- <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                    <div class="bg-RFM-Black">
                        <div class="p-5">
                            <canvas id="chartjs-7" class="chartjs" width="undefined" height="undefined"></canvas>
                            <script> -->
<!--
                            // setup
                            const data = {
                            datasets: [{
                                label: 'RFM Results',
                                data:
                                                        array
                                                    ,
                                                    backgroundColor: [
                                                        'rgba(241, 0, 81, 0.2)'
                                                        ],
                                                        borderColor: [
                                                        'rgba(241, 0, 81, 1)'
                                                        ],
                                                        borderWidth: 1
                                                    }]
                            };

                            // config
                            const config = {
                            type: 'bubble',
                            data,
                            options: {
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: (context) => {
                                                return `Client ID: ${context.raw.clientID},  ${context.raw.clientStatus}`
                                            }
                                        }
                                    }
                                },
                                scales: {
                                y: {
                                    beginAtZero: true
                                }
                                }
                            }
                            };

                            // render init block
                            const myChart = new Chart(
                            document.getElementById('chartjs-7'),
                            config
                            );
                            </script>
                        </div>
                    </div>
                        </div> -->
                    <!--/Graph Card-->
                <!-- </div> -->




                <div class="w-full p-3">
                    <!--Graph Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                         <div class="bg-RFM-Black">
                                 <div class="p-5">
                                     <!-- <div id="chartdiv"></div> -->
                                     <div id="chartdiv" width="undefined" height="undefined"></div>
                                     <script>
                                            /**
                                         * ---------------------------------------
                                         * This demo was created using amCharts 5.
                                         *
                                         * For more information visit:
                                         * https://www.amcharts.com/
                                         *
                                         * Documentation is available at:
                                         * https://www.amcharts.com/docs/v5/
                                         * ---------------------------------------
                                         */

                                        // Create root element
                                        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                                        var root = am5.Root.new("chartdiv");


                                        // Set themes
                                        // https://www.amcharts.com/docs/v5/concepts/themes/
                                        var myTheme = am5themes_Animated.new(root);

                                        myTheme.rule("AxisLabel").setAll({
                                        fill: am5.color(0x7a7a7a)
                                        });

                                        root.setThemes([
                                        myTheme
                                        ]);

                                        // Create chart
                                        // https://www.amcharts.com/docs/v5/charts/xy-chart/
                                        var chart = root.container.children.push(am5xy.XYChart.new(root, {
                                        panX: true,
                                        panY: true,
                                        wheelY: "zoomXY",
                                        pinchZoomX:true,
                                        pinchZoomY:true,
                                        }));

                                        // Create axes
                                        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                                        var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                                        renderer: am5xy.AxisRendererX.new(root, {}),
                                        tooltip: am5.Tooltip.new(root, {})
                                        }));


                                        xAxis.children.moveValue(am5.Label.new(root, {
                                        text: "Monetory →",
                                        fill: am5.color(0x7a7a7a),
                                        x: am5.p50,
                                        centerX: am5.p50
                                        }), xAxis.children.length - 1);

                                        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                                        renderer: am5xy.AxisRendererY.new(root, {
                                            inversed: false
                                        }),
                                        tooltip: am5.Tooltip.new(root, {})
                                        }));

                                        yAxis.children.moveValue(am5.Label.new(root, {
                                        rotation: -90,
                                        text: "Recency →",
                                        fill: am5.color(0x7a7a7a),
                                        y: am5.p50,
                                        centerX: am5.p50
                                        }), 0);

                                        // Create series
                                        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                                        var series = chart.series.push(am5xy.LineSeries.new(root, {
                                        calculateAggregates: true,
                                        xAxis: xAxis,
                                        yAxis: yAxis,
                                        valueYField: "y",
                                        valueXField: "x",
                                        valueField: "value",
                                        seriesTooltipTarget:"bullet",
                                        tooltip: am5.Tooltip.new(root, {
                                            pointerOrientation: "horizontal",
                                            labelText: "[bold]Client ID: {title} [/]\nTotal Revenue: {value.formatNumber('#,###.')}\nSegment: {continent}"
                                        })
                                        }));

                                        series.strokes.template.set("visible", false);


                                        // Add bullet
                                        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/#Bullets
                                        var circleTemplate = am5.Template.new({});
                                        circleTemplate.adapters.add("fill", function(fill, target) {
                                        var dataItem = target.dataItem;
                                        if (dataItem) {
                                            return am5.Color.fromString(dataItem.dataContext.color);
                                        }
                                        return fill
                                        });
                                        series.bullets.push(function() {
                                        var bulletCircle = am5.Circle.new(root, {
                                            radius: 5,
                                            fill: series.get("fill"),
                                            fillOpacity: 0.8
                                        }, circleTemplate);
                                        return am5.Bullet.new(root, {
                                            sprite: bulletCircle
                                        });
                                        });


                                        // Add heat rule
                                        // https://www.amcharts.com/docs/v5/concepts/settings/heat-rules/
                                        series.set("heatRules", [{
                                        target: circleTemplate,
                                        min: 3,
                                        max: 60,
                                        dataField: "value",
                                        key: "radius"
                                        }]);

                                        // Set data
                                        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/#Setting_data

                                        let bubbleArray = [];


                                        array.forEach((current)=>{
                                            let randomColor = Math.floor(Math.random()*16777215).toString(16);

                                            newArray =

                                                    {
                                                        "title": current.clientID,
                                                        "id": current.clientID,
                                                        "color": "#" + randomColor,
                                                        "continent": current.clientStatus,
                                                        "x": current.x,
                                                        "y": current.y,
                                                        "value": current.totalRevenue
                                                    },

                                                    bubbleArray.push(newArray)
                                        })


                                            series.data.setAll(

                                                bubbleArray
                                            );


                                        // Add cursor
                                        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                                        chart.set("cursor", am5xy.XYCursor.new(root, {
                                        xAxis: xAxis,
                                        yAxis: yAxis,
                                        snapToSeries: [series]
                                        }));


                                        // Add scrollbars
                                        // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
                                        chart.set("scrollbarX", am5.Scrollbar.new(root, {
                                        orientation: "horizontal"
                                        }));

                                        chart.set("scrollbarY", am5.Scrollbar.new(root, {
                                        orientation: "vertical"
                                        }));



                                        // Make stuff animate on load
                                        // https://www.amcharts.com/docs/v5/concepts/animations/
                                        series.appear(1000);
                                        chart.appear(1000, 100);
                                    </script>
                                </div>
                        </div>
                    </div>
                    <!--/Graph Card-->
                </div>

                <div class="w-full p-3">
                    <!--Graph Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                         <div class="bg-RFM-Black">
                                 <div class="p-5">
                                     <!-- <div id="chartdiv"></div> -->
                                     <style>
                                         #chartdivBar {
                                        width: 100%;
                                        height: 600px;
                                        }
                                     </style>
                                     <div id="chartdivBar" width="undefined" height="undefined"></div>

                                     <script>
                                        am5.ready(function() {

                                        // Create root element
                                        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                                        var root = am5.Root.new("chartdivBar");


                                        // Set themes
                                        // https://www.amcharts.com/docs/v5/concepts/themes/
                                        var myTheme = am5themes_Animated.new(root);

                                        myTheme.rule("AxisLabel").setAll({
                                        fill: am5.color(0x7a7a7a)
                                        });

                                        root.setThemes([
                                        myTheme
                                        ]);


                                        // Create chart
                                        // https://www.amcharts.com/docs/v5/charts/xy-chart/
                                        var chart = root.container.children.push(am5xy.XYChart.new(root, {
                                        panX: true,
                                        panY: true,

                                        pinchZoomX:false
                                        }));

                                        // Add cursor
                                        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                                        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                                        cursor.lineY.set("visible", false);


                                        // Create axes
                                        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                                        var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
                                        xRenderer.labels.template.setAll({
                                        rotation: -90,
                                        centerY: am5.p50,
                                        centerX: am5.p100,
                                        paddingRight: 15
                                        });

                                        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                                        maxDeviation: 0.3,
                                        categoryField: "segment",
                                        renderer: xRenderer,
                                        tooltip: am5.Tooltip.new(root, {})
                                        }));

                                        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                                        maxDeviation: 0.3,
                                        renderer: am5xy.AxisRendererY.new(root, {})
                                        }));


                                        // Create series
                                        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                                        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                                        name: "Series 1",
                                        xAxis: xAxis,
                                        yAxis: yAxis,
                                        valueYField: "value",
                                        sequencedInterpolation: true,
                                        categoryXField: "segment",
                                        tooltip: am5.Tooltip.new(root, {
                                            labelText:"{valueY}"
                                        })
                                        }));

                                        series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5 });
                                        series.columns.template.adapters.add("fill", function(fill, target) {
                                        return chart.get("colors").getIndex(series.columns.indexOf(target));
                                        });

                                        series.columns.template.adapters.add("stroke", function(stroke, target) {
                                        return chart.get("colors").getIndex(series.columns.indexOf(target));
                                        });
                                            var res = array.reduce(function(obj, v) {
                                                obj[v.clientStatus] = (obj[v.clientStatus] || 0) + 1;
                                                return obj;
                                            }, {})

                                            var seg = Object.keys(res).map((k) => ({segment: k, value: res[k]}));

                                        // Set data
                                        var data = seg;

                                        xAxis.data.setAll(data);
                                        series.data.setAll(data);


                                        // Make stuff animate on load
                                        // https://www.amcharts.com/docs/v5/concepts/animations/
                                        series.appear(1000);
                                        chart.appear(1000, 100);

                                        }); // end am5.ready()
                                        </script>
                                </div>
                        </div>
                    </div>
                    <!--/Graph Card-->
                </div>

			<!--/ Console Content-->

		</div>


	</div>
	<!--/container-->


			<!--Divider-->
			<hr class="border-b-2 border-RFM-Orange my-8 mx-4">


        <footer class="bg-RFM-Black">
		    <div class="container max-w-md mx-auto flex py-8">

			<div class="w-full mx-auto flex flex-wrap">
				<div class="flex w-full md:w-1/2 ">
					<div class="px-8">
						<h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">About</h3>
						<p class="mt-1 block text-base text-gray-300">
                        Designers en developers weten wij altijd het maximale uit de e-commerce van onze klanten te halen.
						</p>
					</div>
				</div>

				<div class="flex w-full md:w-1/2">
					<div class="px-8">
					<h3 class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">Social</h3>
						<ul class="flex" style="justify-content: center; grid-gap: 20px;">
						  <li>
							<a class="mt-1 block text-base text-gray-300" href="https://nl.linkedin.com/company/global-marketing-unity" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: LinkedIn"><p><i class="fab fa-linkedin fa-spin" style="font-size:30px"></i></p></a>
						  </li>
						  <li>
							<a class="mt-1 block text-base text-gray-300" href="https://www.instagram.com/gmu_online/" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: Instagram"><p><i class="fab fa-instagram fa-spin" style="font-size:30px"></i></p></a>
						  </li>
							<li>
							<a class="mt-1 block text-base text-gray-300" href="https://www.facebook.com/GMU.online/" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: Facebook"><p><i class="fab fa-facebook fa-spin" style="font-size:30px"></i></p></a>
						  </li>
						</ul>
					</div>
				</div>
			</div>

            <ul>
                <li class="no-childnodes"><a fab="" href="https://nl.linkedin.com/company/global-marketing-unity" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: LinkedIn"></a></li><li class="no-childnodes"><a fab="" href="https://www.instagram.com/gmu_online/" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: Instagram"></a></li><li class="no-childnodes"><a fab="" href="https://www.facebook.com/GMU.online/" rel="nofollow noopener noreferrer" target="_blank" title="Volg ons op: Facebook"></a></li></ul>
        </div>
	    </footer>


<script>


	/*Toggle dropdown list*/
	/*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

	var userMenuDiv = document.getElementById("userMenu");
	var userMenu = document.getElementById("userButton");

	var navMenuDiv = document.getElementById("nav-content");
	var navMenu = document.getElementById("nav-toggle");

	document.onclick = check;

	function check(e){
	  var target = (e && e.target) || (event && event.srcElement);

	  //User Menu
	  if (!checkParent(target, userMenuDiv)) {
		// click NOT on the menu
		if (checkParent(target, userMenu)) {
		  // click on the link
		  if (userMenuDiv.classList.contains("invisible")) {
			userMenuDiv.classList.remove("invisible");
		  } else {userMenuDiv.classList.add("invisible");}
		} else {
		  // click both outside link and outside menu, hide menu
		  userMenuDiv.classList.add("invisible");
		}
	  }

	  //Nav Menu
	  if (!checkParent(target, navMenuDiv)) {
		// click NOT on the menu
		if (checkParent(target, navMenu)) {
		  // click on the link
		  if (navMenuDiv.classList.contains("hidden")) {
			navMenuDiv.classList.remove("hidden");
		  } else {navMenuDiv.classList.add("hidden");}
		} else {
		  // click both outside link and outside menu, hide menu
		  navMenuDiv.classList.add("hidden");
		}
	  }

	}

	function checkParent(t, elm) {
	  while(t.parentNode) {
		if( t == elm ) {return true;}
		t = t.parentNode;
	  }
	  return false;
	}


</script>

</body>
</html>


@endsection
