import "./bootstrap";
import Search from "./live-search";

// If user is logged in, the search icon si visible
if (document.querySelector(".header-search-icon")) {
    new Search();
}
