import * as JSC from "jscharting";

const templateFilehistorytype = await fetch("src/ui/country/template.html");
const templatehistorytype = await templateFilehistorytype.text();
document.getElementById("country").innerHTML = templatehistorytype;

let Country = {};

Country.render = function (data) {
  JSC.chart("countrygraph", {
    debug: false,
    type: "treemap cushion",
    // type: "treemapStripesSolid",
    legend_visible: false,
    defaultPoint: {
      label_text: "<b>%name</b>",
    },
    defaultSeries_shape: {
      label: {
        text: "%name",
        color: "#f2f2f2",
        style: { fontSize: 15, fontWeight: "bold" },
      },
    },
    series: [
      {
        name: "Ventes",
        points: data[0].map((item) => ({
          name: item.country,
          y: item.total,
        })),
      },
      {
        name: "Locations",
        points: data[1].map((item) => ({
          name: item.country,
          y: item.total,
        })),
      },
    ],
  });
};

export { Country };
