import { genericRenderer } from "../../lib/utils.js";

const templateFile = await fetch("src/ui/price/template.html");
const template = await templateFile.text();

let PriceView = {};

PriceView.render = function () {
  let html = "";
  if (!Array.isArray(data)) {
    data = [data];
  }
  for (let obj of data) {
    html += genericRenderer(template, obj);
  }
};

export { PriceView };
