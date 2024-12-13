import * as JSC from "jscharting";
import { genericRenderer } from "../../lib/utils.js";

const templateFile = await fetch("src/ui/historybyid/template.html");
const template = await templateFile.text();

const template2File = await fetch("src/ui/historybyid/template2.html");
const template2 = await template2File.text();

let Historybyid = {};

Historybyid.select = function (data) {
  let html = "";
  let valuesHtml = "";
  if (!Array.isArray(data)) {
    data = [data];
  }
  for (let obj of data) {
    valuesHtml += genericRenderer(template2, obj);
  }
  html = template.replace("{{options}}", valuesHtml);
  document.getElementById("historybyid").innerHTML = html;
  return html;
};

Historybyid.render = function (data) {
  JSC.chart("historybyidgraph", {
    debug: false,
    type: "line",
    legend_visible: true,
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
        color: "green",
        name: "Achats",
        points: data.map((item) => [item.month, parseFloat(item.total_sales)]),
      },
      {
        color: "orange",
        name: "Locations",
        points: data.map((item) => [
          item.month,
          parseFloat(item.total_rentals),
        ]),
      },
    ],
  });
};

export { Historybyid };
