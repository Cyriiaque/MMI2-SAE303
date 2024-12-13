import * as JSC from "jscharting";
import { genericRenderer } from "../../lib/utils.js";

const templateFile = await fetch("src/ui/customerviews/template.html");
const template = await templateFile.text();

const template2File = await fetch("src/ui/customerviews/template2.html");
const template2 = await template2File.text();

let Customerviews = {};

Customerviews.select = function (data) {
  let html = "";
  let valuesHtml = "";
  if (!Array.isArray(data)) {
    data = [data];
  }
  for (let obj of data) {
    valuesHtml += genericRenderer(template2, obj);
  }
  html = template.replace("{{options}}", valuesHtml);
  document.getElementById("customerviews").innerHTML = html;
  return html;
};

Customerviews.render = function (data) {
  JSC.chart("customerviewsgraph", {
    debug: false,
    type: "radarPolarColumnCushion",
    legend_visible: false,
    yAxis_formatString: "c",
    xAxis: {
      spacingPercentage: -0.01,
      defaultTick_label_style_fontSize: "13px",
    },
    defaultSeries: {
      opacity: 0.7,
      defaultPoint: {
        outline_width: 0,
        marker: { outline_color: "white", size: 12 },
      },
      defaultPoint_tooltip: "%name<br><b>%value</b>",
    },
    series: [
      {
        points: data.map((item) => ({
          name: item.genre,
          y: item.count,
        })),
      },
    ],
  });
};

export { Customerviews };
