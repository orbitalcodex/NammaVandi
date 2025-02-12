<!DOCTYPE html>
<html lang="en">

<head>
    <title>NAMMA VANDI RENTAL SERVICE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png" style="width: 100px; height: 100px;">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap" rel="stylesheet">

    <link href="https://example.com/CloneWarsFont.css" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">


    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Google Maps Async Load -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false" async
        defer></script>
</head>

<body>

    <div id="loading-overlay" class="loading-overlay" style="visibility: hidden;">
        <img src="{{ asset('assets/Videos/loading.gif') }}" alt="Loading..." class="loading-image">
    </div>

    @yield('content') <!-- Content will be injected here -->


    <!-- JS Libraries -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/scrollax.min.js') }}"></script>
    <script src="{{ asset('assets/js/google-map.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const loadingOverlay = document.getElementById("loading-overlay");

        // Function to show loading
        function showLoading() {
            loadingOverlay.style.visibility = "visible";
        }

        // Function to hide loading when both containers have updated
        function hideLoading() {
            let checkDataLoaded = setInterval(() => {
                const bikesLoaded = document.querySelector("#bikes-container")?.children.length > 0;
                const carsLoaded = document.querySelector("#cars-container")?.children.length > 0;

                if ((bikesLoaded || !document.getElementById("bikes-container")) && 
                    (carsLoaded || !document.getElementById("cars-container")) &&
                    document.readyState === "complete") {
                    
                    loadingOverlay.style.visibility = "hidden";
                    clearInterval(checkDataLoaded);
                }
            }, 500); // Keeps checking every 500ms
        }

        // Show loading overlay when any form is submitted
        document.querySelectorAll("form").forEach(form => {
            form.addEventListener("submit", function () {
                showLoading();
            });
        });

        // Show loading overlay for AJAX requests (for Laravel apps using jQuery)
        $(document).ajaxStart(showLoading);
        $(document).ajaxStop(hideLoading);

        // Ensure loading stays until data is fully fetched
        window.onload = function () {
            showLoading(); // Keep showing loading until all data is fetched
            hideLoading();
        };

        // Show loading when clicking any external link
        document.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", function (event) {
                if (this.hostname && this.hostname !== window.location.hostname) {
                    showLoading();
                }
            });
        });

        // Browser reload - Show loading before reload
        window.addEventListener("beforeunload", function () {
            showLoading();
        });

        // Show loading overlay when a filter is applied and automatically hide it when filtering completes
        document.querySelectorAll(".filter-button, .filter-select").forEach(element => {
            element.addEventListener("change", function () {
                showLoading();

                // Use MutationObserver to detect when both `bikes` and `cars` containers are updated
                let updatedBikes = false;
                let updatedCars = false;

                function checkAndHideLoading() {
                    if (updatedBikes && updatedCars) {
                        hideLoading();
                        observerBikes.disconnect();
                        observerCars.disconnect();
                    }
                }

                // Observe changes in the bikes container
                const bikesContainer = document.getElementById("bikes-container");
                const observerBikes = new MutationObserver(() => {
                    updatedBikes = true;
                    checkAndHideLoading();
                });

                if (bikesContainer) {
                    observerBikes.observe(bikesContainer, { childList: true, subtree: true });
                } else {
                    updatedBikes = true; // If container doesn't exist, mark it as updated
                }

                // Observe changes in the cars container
                const carsContainer = document.getElementById("cars-container");
                const observerCars = new MutationObserver(() => {
                    updatedCars = true;
                    checkAndHideLoading();
                });

                if (carsContainer) {
                    observerCars.observe(carsContainer, { childList: true, subtree: true });
                } else {
                    updatedCars = true; // If container doesn't exist, mark it as updated
                }
            });
        });

        // Ensure overlay doesn't persist after navigating back in history (e.g., swipe back)
        window.addEventListener("pageshow", function (event) {
            if (event.persisted) {
                hideLoading(); // Hide overlay if coming from cache
            }
        });

        // Hide loading overlay in case of browser history navigation (back or forward)
        window.addEventListener("popstate", hideLoading);
    });
</script>






</body>

</html>