@extends('layouts.app')

@section('content')

<body class="bg-RFM-Black font-sans leading-normal tracking-normal">

        <script>
            let array = [];
            let arr = @json($data);

            arr.forEach((current)=>{
                newArray = {
                    x: current['frequency'],
                    y: current['recency'],
                    clientID: current['customer_id'],
                    clientStatus: current['segment'],
                    totalRevenue: current['monetary'],
                    color: "##F10051",
                }

                array.push(newArray)
            })

            //Code to parse the strings value to numbers in the array

            for(var i = 0; i < arr.length; i++){
                var obj = arr[i];
                for(var prop in obj){
                    if(obj.hasOwnProperty(prop) && obj[prop] !== null && !isNaN(obj[prop])){
                        obj[prop] = +obj[prop];
                    }
                }
            }

            //code to sum the total value of the monetary
            var res = arr.reduce(function(_this, val) {
                return _this + val.monetary
            }, 0);



            //Code to set up the bubble chart
            let bubbleArray = [];


            array.forEach((current)=>{
                let randomColor = Math.floor(Math.random()*16777215).toString(16);

                newArray =

                    {
                        "title": current.clientID,
                        "id": current.clientID,
                        "color": "#" + randomColor,
                        "continent": current.clientStatus,
                        "x": current.x, //frequency
                        "y": current.y, // recency
                        "value": current.totalRevenue
                    },

                    bubbleArray.push(newArray)
            })

        </script>

        <nav id="header" class="bg-RFM-Black fixed w-full z-10 top-0 shadow"></nav>


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




    <!--Container-->
    <div class="container w-full mx-auto pt-20">

        <div class="w-full px-4 md:px-0 md:mt-8 mb-8 text-gray-800 leading-normal">

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
                                <h3 id="total" class="block text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-RFM-Pink to-RFM-Orange">&euro;<script>document.write(Math.round(res))</script> <span class="text-green-500"><i class="fas fa-caret-up"></i></span></h3>
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
                            <div id="new_customers">
                                <new-customers></new-customers>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>

            </div>

			<!--Divider-->

			<div class="bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange my-8 mx-4"></div>
            <div  id="app">
            @if (Laratrust::hasRole(['admin', 'marketer']))
                @auth
                        <div id="xslx">
                            <xslx-download></xslx-download>
                        </div>
                @endauth
            @endif
            </div>
        </div>
        <div id="bubble">
            <bubble-chart></bubble-chart>
        </div>

            <div class="flex flex-row flex-wrap flex-grow mt-2">
{{--                bubble chart--}}
                <div class="w-full p-3">
                    <!--Graph Card-->
                    <div class="p-0.5 bg-gradient-to-tr from-RFM-Cyan to-RFM-Orange rounded shadow">
                         <div class="bg-RFM-Black">
                                 <div class="p-5">
                                     <!-- <div id="chartdiv"></div> -->
                                     <div id="bubbleChart"></div>
                                     <script>
                                        // Create root element
                                        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                                        var root = am5.Root.new("bubbleChart");

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
                                        text: "Frequency →",
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
                                            labelText: "[bold]Client ID: {title} [/]\nTotal Revenue: €{value.formatNumber('#,###.')}\nSegment: {continent}"
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
                                     <div id="barChart" width="undefined" height="undefined"></div>
                                     <script>
                                        am5.ready(function() {

                                        // Create root element
                                        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                                        var root = am5.Root.new("barChart");


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



</body>
    </html>


@endsection
<script>
    import BubbleChart from "../js/components/BubbleChart";
    import NewCustomers from "../js/components/NewCustomers";
    export default {
        components: {NewCustomers, BubbleChart}
    }
</script>
