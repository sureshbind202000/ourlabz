<footer class="footer">
    <div class="row g-0 justify-content-between fs-10 mt-4 mb-3">
        <div class="col-12 col-sm-auto text-center">
            <p class="mb-0 text-600">All Rights Reserved <span class="d-none d-sm-inline-block">|
                </span><br class="d-sm-none" /> {{ date('Y') }} &copy; <a href="#">Ourlabz</a></p>
        </div>
    </div>
</footer>
<!-- Barcode Scan Modal -->
<div class="modal fade" id="barcode-scan-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan Barcode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    onclick="stopBarcodeScanner()"></button>
            </div>
            <div class="modal-body">
                <div id="barcode-scanner" style="width:100%; height:300px; background:#000;"></div>
                <div id="scan-result" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>
