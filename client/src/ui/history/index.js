import * as JSC from "jscharting";

const templateFilehistory = await fetch("src/ui/history/template.html");
const templatehistory = await templateFilehistory.text();

document.getElementById("history").innerHTML = templatehistory;

let History = {};

History.render = function (data) {
  JSC.chart("historygraph", {
    debug: false,
    type: "spline",
    legend_visible: false,
    axisToZoom: "x",
    xAxis: {
      scale_zoomLimit: {
        unit: "hour",
        multiplier: 5,
      },
      crosshair_enabled: true,
      scale: { type: "time" },
    },
    yAxis: {
      orientation: "opposite",
      formatString: "c",
    },
    defaultSeries: {
      lastPoint_label_text: "<b>%seriesName</b>",
      defaultPoint_marker: {
        type: "circle",
        size: 8,
        fill: "white",
        outline: { width: 2, color: "currentColor" },
      },
    },
    series: [
      {
        name: "Achats",
        points: data[0].map((item) => [
          item.month,
          parseFloat(item.total_sales),
        ]),
      },
      {
        name: "Locations",
        points: data[1].map((item) => [
          item.month,
          parseFloat(item.total_rentals),
        ]),
      },
    ],
  });
};

export { History };
