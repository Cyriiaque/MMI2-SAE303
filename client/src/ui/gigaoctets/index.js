import * as JSC from "jscharting";

const templateFile = await fetch("src/ui/gigaoctets/template.html");
const template = await templateFile.text();

document.getElementById("gigaoctets").innerHTML = template;

let Gigaoctets = {};

Gigaoctets.render = function (data) {
  var palette = ["#3c506b", "#577399", "#BDD5EA", "#F7F7FF"].reverse();
  const transformedData = data.map((item) => ({
    x: item.Mois,
    y: item.Pays,
    z: item.Consommation_GB,
  }));
  JSC.chart("gigaoctetsgraph", {
    box_fill: "none",
    type: "heatmap solid",
    overlapBranding: true,
    palette: {
      pointValue: function (p) {
        let valuedata = p.options("z") / 4;
        return valuedata;
      },
      colors: palette,
    },
    legend_visible: false,
    defaultAxis_defaultTick: {
      line_visible: false,
      label: { color: "#263238", maxWidth: 80 },
      placement: "outside",
    },
    xAxis_defaultTick_padding: -2,
    defaultPoint: {
      outline_width: 0,
      tooltip: "%yValue - %xValue<br><b>%zValue Go</b>",
    },
    series: [{ points: transformedData }],
  });
};

export { Gigaoctets };
