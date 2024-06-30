// The below variable stores the application base url, example: http://192.167.44.252/amsted/example-directory
const APP_URL = `${window.location.protocol}//${window.location.host}`;

/**
 * Responsible for obtaining Query String parameters
 * @returns {object} - Params of url
 */
function getQuery() {
  var params = {};
  var queryString = window.location.search.substring(1);

  if (queryString) {
    var queries = queryString.split("&");
    queries.forEach(function (query) {
      var parts = query.split("=");
      params[decodeURIComponent(parts[0])] = decodeURIComponent(parts[1] || "");
    });
  }
  return params;
}

/**
 * Responsible for obtaining an element by ID
 * @param {String} id
 * @returns object - Params of url
 */
function getElement(inputId) {
  let input = document.getElementById(inputId);
  if (input) return input;
  return false;
}

/**
 * Responsible for displaying or hiding the loader
 * @param {String} action
 */
function loader(action) {
  let loaderWrapper = document.querySelector(".loader-wrapper");
  if (loaderWrapper) {
    if (action === "show") loaderWrapper.classList.add("active");
    else if (action === "hidden") loaderWrapper.classList.remove("active");
  }
}

/**
 * This method aims to set the value of a field through the ID
 * @param {String} id
 * @param {*} value
 * @return {true|false}
 */
function setValueById(id, value) {
  if ((element = document.getElementById(id))) {
    element.value = value;
    return true;
  }
  return false;
}



async function getPage(url) {
  try {
    const response = await fetch(url);
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    const data = await response.text();
    return data;
  } catch (error) {
    console.error('Houve um problema ao tentar buscar o arquivo:', error);
    return null;
  }
}