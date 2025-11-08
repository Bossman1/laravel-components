import {initFlowbite} from "flowbite";
window.InitFlowbite = initFlowbite;
import 'lazysizes';
import 'preline';
import 'preline/dist/preline.js';

document.addEventListener('DOMContentLoaded', () => {
    window.HSStaticMethods?.autoInit();
});

import "flatpickr/dist/flatpickr.min.css";
import "flatpickr/dist/plugins/monthSelect/style.css";
import { Splide } from "@splidejs/splide";

window.Splide = Splide;