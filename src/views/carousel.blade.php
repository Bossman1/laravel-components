@props([
    'class'=> uniqid(),
    'containerClass'=> '',
    'containerInlineClass'=> '',
    'splideTrackClass'=> '',
    'perPage' => 4,
    'perPageMobile' => 1,
    'perPageTablet' => 2,
    'showArrows' => true,
    'pagination' => true,
    'type' => 'loop',
    'gap' =>'1rem',
    'id' =>'id_'.uniqid(),
])
<div

    data-type="{{ $type }}"
    data-per-page="{{ $perPage }}"
    data-per-page-mobile="{{ $perPageMobile }}"
    data-per-page-tablet="{{ $perPageTablet }}"
    data-show-arrows="{{ $showArrows }}"
    data-pagination="{{ $pagination }}"
    data-gap="{{ $gap }}"

    id="{{ $id }}"
    class="splide selector-{{ $class  }} w-full {{ $containerClass }}" @if(isset($attributes['data-splide-options'])) data-splide-options="{{ $attributes['data-splide-options'] }}" @endif style="padding-bottom: 20px; {{ $containerInlineClass }}">
    <div class="splide__arrows"></div>
    <div class="splide__track" style="padding-bottom: 20px; {{ $splideTrackClass }}">
    <ul class="splide__list" style="padding-bottom: 20px">
        {{-- render slot raw; JS will wrap each direct child into <li class="splide__slide"> --}}
        {!! trim($slot) !!}
    </ul>
</div>
</div>
<script>
    (() => {
        // Make sure function exists only once
        if (!window.reInitSplides) {
            window.reInitSplides = function (context = document) {
                context.querySelectorAll(".splide").forEach((root) => {
                    if (root.dataset.splideInitialized === "true") return; // skip already initialized

                    const list = root.querySelector(".splide__list");
                    if (!list) return;

                    // Wrap slides if not yet wrapped
                    Array.from(list.children).forEach((child) => {
                        if (child.tagName.toLowerCase() !== "li" || !child.classList.contains("splide__slide")) {
                            const li = document.createElement("li");
                            li.className = "splide__slide";
                            list.replaceChild(li, child);
                            li.appendChild(child);
                        }
                    });

                    // Parse options safely
                    let opts = {};
                    try {
                        if (root.dataset.splideOptions) opts = JSON.parse(root.dataset.splideOptions);
                    } catch (e) {
                        console.error("Invalid JSON in data-splide-options:", e);
                    }
                    // console.log(root.dataset.pagination);
                    // console.log(root.dataset.showArrows);
                    // console.log(root.dataset);
                    const defaultOptions = {
                        type: root.dataset.type || "loop",
                        perPage: parseInt(root.dataset.perPage) || 4,
                        gap: root.dataset.gap || "1rem",
                        autoplay: false,
                        pauseOnHover: false,
                        pagination: root.dataset.pagination ,
                        arrows: root.dataset.showArrows,
                        classes: {
                            prev: "splide__arrow--prev splide-custom-class-prev",
                            next: "splide__arrow--next splide-custom-class-next",
                        },
                        breakpoints: {
                            1024: { perPage: parseInt(root.dataset.perPageTablet) || 2 },
                            640: { perPage: parseInt(root.dataset.perPageMobile) || 1 },
                        },
                    };

                    const splide = new Splide(root, { ...defaultOptions, ...opts });

                    const replaceArrows = () => {
                        root.querySelectorAll(".splide-custom-class-prev").forEach(el => {
                            el.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none"/>
                            <polyline points="96 48 176 128 96 208" fill="none"
                                      stroke="currentColor" stroke-linecap="round"
                                      stroke-linejoin="round" stroke-width="16"/>
                        </svg>`;
                        });

                        root.querySelectorAll(".splide-custom-class-next").forEach(el => {
                            el.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none"/>
                            <polyline points="96 48 176 128 96 208" fill="none"
                                      stroke="currentColor" stroke-linecap="round"
                                      stroke-linejoin="round" stroke-width="16"/>
                        </svg>`;
                        });
                    };

                    splide.on("mounted", replaceArrows);
                    splide.on("updated", replaceArrows);

                    splide.mount();
                    root.dataset.splideInitialized = "true";

                    window.splideInstances = window.splideInstances || {};
                    window.splideInstances[root.id] = splide;
                });
            };

            // Observe DOM insertions (optional but powerful)
            const observer = new MutationObserver((mutations) => {
                for (const mutation of mutations) {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === 1 && node.querySelector(".splide")) {
                            window.reInitSplides(node);
                        }
                    });
                }
            });
            observer.observe(document.body, { childList: true, subtree: true });
        }

        // Run immediately after page load
        document.addEventListener("DOMContentLoaded", () => window.reInitSplides());
    })();
</script>

