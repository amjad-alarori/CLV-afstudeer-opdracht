<!-- Below code is tested on SheetJS v0.14.0 -->
<template>
    <div id="barChart" width="undefined" height="undefined"></div></template>
<script>

import axios from 'axios'

export default {
    data() {
        return {
            totalCustomers: ''
        };
    },

    async created() {
        try {
            const get = await axios.get('http://clv.test/rfms');
            let array = [];
            let arr = get.data;

            arr.forEach((current)=>{
                let newArray;
                newArray = {
                    x: current['frequency'],
                    y: current['recency'],
                    clientID: current['customer_id'],
                    clientStatus: current['segment'],
                    totalRevenue: Math.round(current['monetary']),
                    color: "##F10051",
                }

                array.push(newArray)
            })

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


        } catch (e) {
            console.error(e);
        }
    }
};



</script>



