import { CurrentMonth } from "./ui/currentmonth/index.js";
import { Ranking } from "./ui/ranking/index.js";
import { History } from "./ui/history/index.js";
import { HistorybyType } from "./ui/historybytype/index.js";
import { Country } from "./ui/country/index.js";

import { MoviesData } from "./data/movies.js";
import { CustomersData } from "./data/customers.js";

import "./index.css";

let C = {};

C.loadCurrent = async function () {
  let data = await MoviesData.currentmonth();
  V.renderCurrent(data);
};

C.loadRanking = async function () {
  let data = await MoviesData.ranking();
  V.renderRanking(data);
};

C.loadHistory = async function () {
  let data = await MoviesData.history();
  V.renderHistory(data);
};

C.loadHistoryType = async function () {
  if (V.historybytypeselect.value === "ventes") {
    let data = await MoviesData.historybytypesales();
    V.renderHistoryType(data);
  } else {
    let data = await MoviesData.historybytyperentals();
    V.renderHistoryType(data);
  }
};

C.loadCountry = async function () {
  let data = await CustomersData.country();
  V.renderCountry(data);
};

C.init = async function () {
  V.init();
};

let V = {
  currentmonth: document.querySelector("#currentmonth"),
  ranking: document.querySelector("#ranking"),
  history: document.querySelector("#history"),
  historybytype: document.querySelector("#historybytype"),
  historybytypeselect: document.querySelector("#historybytypeselect"),
  country: document.querySelector("#country"),
};

V.init = function () {
  C.loadCurrent();
  C.loadRanking();
  C.loadHistory();
  C.loadHistoryType();
  C.loadCountry();
};

V.renderCurrent = async function (data) {
  V.currentmonth.innerHTML = CurrentMonth.render(data);
};

V.renderRanking = async function (data) {
  V.ranking.innerHTML = Ranking.render(data);
};

V.renderHistory = async function (data) {
  V.history = History.render(data);
};

V.renderHistoryType = async function (data) {
  V.historybytype = HistorybyType.render(data);
};

V.renderCountry = async function (data) {
  V.country = Country.render(data);
};

C.init();

historybytypeselect.addEventListener("change", C.loadHistoryType);
