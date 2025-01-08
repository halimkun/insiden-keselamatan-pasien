import './bootstrap';
import "../css/satoshi.css";

import Alpine from 'alpinejs';
import persist from "@alpinejs/persist";
import SignaturePad from 'signature_pad';

Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();

window.SignaturePad = SignaturePad;