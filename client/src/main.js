import { CurrentMonth } from "./ui/currentmonth/index.js";
import { Ranking } from "./ui/ranking/index.js";
import { History } from "./ui/history/index.js";
import { HistorybyType } from "./ui/historybytype/index.js";
import { Country } from "./ui/country/index.js";
import { Customerviews } from "./ui/customerviews/index.js";
import { Historybyid } from "./ui/historybyid/index.js";
import { Gigaoctets } from "./ui/gigaoctets/index.js";

import { MoviesData } from "./data/movies.js";
import { CustomersData } from "./data/customers.js";

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

C.loadCustomerselect = async function () {
  let data = await CustomersData.name();
  V.renderCustomerselect(data);
};

C.loadCustomerviews = async function () {
  let id = V.customerselect.value;
  let data = await MoviesData.gendernumber(id);
  V.renderCustomerviews(data);
};

C.loadMovieselect = async function () {
  let data = await MoviesData.findall();
  V.renderMovieselect(data);
};

C.loadHistorybyid = async function () {
  let id = V.movieselect.value;
  let data = await MoviesData.historybyid(id);
  V.renderHistorybyid(data);
};

C.loadGigaoctets = async function () {
  let data = await MoviesData.gigaoctets();
  V.renderGigaoctets(data);
};

C.init = async function () {
  V.init();
};

window.V = {
  currentmonth: document.querySelector("#currentmonth"),
  ranking: document.querySelector("#ranking"),
  history: document.querySelector("#history"),
  historybytype: document.querySelector("#historybytype"),
  historybytypeselect: null,
  country: document.querySelector("#country"),
  customerselect: null,
  customerviews: document.querySelector("#customerviews"),
  movieselect: null,
  historybyid: document.querySelector("#historybyid"),
  gigaoctets: document.querySelector("#gigaoctets"),
};

V.init = async function () {
  C.loadCurrent();
  C.loadRanking();
  await C.loadHistory();

  V.historybytypeselect = document.querySelector("#historybytypeselect");
  V.historybytypeselect.addEventListener("change", C.loadHistoryType);

  C.loadHistoryType();
  C.loadCountry();

  await C.loadCustomerselect();
  V.customerselect = document.querySelector("#customerselect");
  V.customerselect.addEventListener("change", C.loadCustomerviews);
  C.loadCustomerviews();

  await C.loadMovieselect();
  V.movieselect = document.querySelector("#movieselect");
  V.movieselect.addEventListener("change", C.loadHistorybyid);
  C.loadHistorybyid();

  C.loadGigaoctets();
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

V.renderCustomerselect = async function (data) {
  V.customerselect = Customerviews.select(data);
};

V.renderCustomerviews = async function (data) {
  V.customerviews = Customerviews.render(data);
};

V.renderMovieselect = async function (data) {
  V.movieselect = Historybyid.select(data);
};

V.renderHistorybyid = async function (data) {
  V.historybyid = Historybyid.render(data);
};

V.renderGigaoctets = async function (data) {
  V.gigaoctets = Gigaoctets.render(data);
};

C.init();
