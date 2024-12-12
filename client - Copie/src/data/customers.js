import { getRequest } from "../lib/api-request.js";

let CustomersData = {};

CustomersData.country = async function () {
  let data = await getRequest("customers?stat=country");
  return data;
};

CustomersData.movies = async function (id) {
  let data = await getRequest("customers?stat=movies&?id=" + id);
  return data;
};

export { CustomersData };
