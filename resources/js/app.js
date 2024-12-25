import './bootstrap';
import "../css/satoshi.css";

import Alpine from 'alpinejs';
import persist from "@alpinejs/persist";


Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();
