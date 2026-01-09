document.addEventListener("DOMContentLoaded", () => {
    if (!window.Echo) {
        console.error("Echo not ready yet!");
        return;
    }

    if (window.userId) {
        console.log("Subscribing to:", `phlebo-tracking.${window.userId}`);

        Echo.private(`phlebo-tracking.${window.userId}`)
            .listen("LocationUpdated", (e) => {
                console.log("Live update:", e.latitude, e.longitude);

                if (typeof updateMapMarker === "function") {
                    updateMapMarker(e.latitude, e.longitude);
                }
            });
    }
});
