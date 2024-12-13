import { getRequest } from "../lib/api-request.js";

let CustomersData = {};

CustomersData.country = async function () {
  let data = await getRequest("customers?stat=country");
  return data;
};

CustomersData.name = async function () {
  let data = await getRequest("customers?stat=name");
  return data;
};

export { CustomersData };
