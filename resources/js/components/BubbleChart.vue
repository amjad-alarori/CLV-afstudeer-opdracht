<!-- Below code is tested on SheetJS v0.14.0 -->
<template>
    <div id="bubbleChart"></div>
</template>

<script>

import axios from 'axios'

export default {

    data() {
        return {
            bubble: ''
        };
    },

    async created() {
        try {
            const get = await axios.get('https://rfm.gmu.online/api/rfms');
            let arr = get.data

            let array = [];
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
            //Code to set up the bubble chart
            let bubbleArray = [];

            array.forEach((current)=>{
                let randomColor = Math.floor(Math.random()*16777215).toString(16);
                let newArray;
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


        } catch (e) {
            console.error(e);
        }
    }
};



</script>





