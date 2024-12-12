import { genericRenderer } from "../../lib/utils.js";

const templateFile = await fetch("src/ui/currentmonth/template.html");
const template = await templateFile.text();

let CurrentMonth = {};

CurrentMonth.render = function (data) {
  let html = "";
  if (!Array.isArray(data)) {
    data = [data];
  }
  for (let obj of data) {
    html += genericRenderer(template, obj);
  }
  return html;
};

export { CurrentMonth };
