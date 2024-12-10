import { PriceView } from "./ui/price/index.js";

import * as JSC from "jscharting";
import "./index.css";

const chart = new JSC.Chart("chartDiv", {
  type: "column",
  series: [
    {
      name: "Teams",
      points: [
        {
          x: "A",
          y: 10,
        },
        {
          x: "B",
          y: 5,
        },
      ],
    },
  ],
});
// let C = {};

// C.init = async function(){
//     V.init();
// }

// let V = {
//     header: document.querySelector("#header")
// };

// V.init = function(){
//     V.renderHeader();
// }

// V.renderHeader= function(){
//     V.header.innerHTML = HeaderView.render();
// }

// C.init();
