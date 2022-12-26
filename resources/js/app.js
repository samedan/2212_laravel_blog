import "./bootstrap";
import Search from "./live-search";
import Chat from "./chat";

// If user is logged in, the search icon si visible
if (document.querySelector(".header-search-icon")) {
    new Search();
}
if (document.querySelector(".header-chat-icon")) {
    new Chat();
}
