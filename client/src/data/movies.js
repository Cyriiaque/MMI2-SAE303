import { getRequest } from "../lib/api-request.js";

let MoviesData = {};

MoviesData.currentmonth = async function () {
  let data = await getRequest("movies?stat=currentmonth");
  return data;
};

MoviesData.ranking = async function () {
  let data = await getRequest("movies?stat=ranking");
  return data;
};

MoviesData.history = async function () {
  let data = await getRequest("movies?stat=history");
  return data;
};

MoviesData.historybytypesales = async function () {
  let data = await getRequest("movies?stat=historybytypesales");
  return data;
};

MoviesData.historybytyperentals = async function () {
  let data = await getRequest("movies?stat=historybytyperentals");
  return data;
};

MoviesData.historybyid = async function (id) {
  let data = await getRequest("movies?stat=historybyid&id=" + id);
  return data;
};

MoviesData.findall = async function () {
  let data = await getRequest("movies?stat=all");
  return data;
};

MoviesData.gendernumber = async function (id) {
  let data = await getRequest("movies?stat=gendernumber&id=" + id);
  return data;
};

MoviesData.gigaoctets = async function () {
  let data = await getRequest("movies?stat=gigaoctets");
  return data;
};

export { MoviesData };
