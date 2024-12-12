import { genericRenderer } from "../../lib/utils.js";

const templateFile = await fetch("src/ui/ranking/template.html");
const template = await templateFile.text();

const template2File = await fetch("src/ui/ranking/template2.html");
const template2 = await template2File.text();

let Ranking = {};

Ranking.render = function (data) {
  let html = "";

  if (Array.isArray(data) && data.length === 2) {
    const [purchaseData, rentalData] = data;

    let valuesHtml = "";

    valuesHtml +=
      "<div class='flex flex-col'><h3 class='text-lg font-medium'>Ventes</h3>";
    for (let obj of purchaseData) {
      obj.count = obj.purchase_count;
      valuesHtml += genericRenderer(template2, obj);
    }
    valuesHtml += "</div>";

    valuesHtml +=
      "<div class='flex flex-col'><h3 class='text-lg font-medium'>Locations</h3>";
    for (let obj of rentalData) {
      obj.count = obj.rental_count;
      valuesHtml += genericRenderer(template2, obj);
    }
    valuesHtml += "</div>";

    html = template.replace("{{values}}", valuesHtml);
  } else {
    if (!Array.isArray(data)) {
      data = [data];
    }
    for (let obj of data) {
      html += genericRenderer(template2, obj);
    }
  }

  return html;
};

export { Ranking };
