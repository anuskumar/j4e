<div class="slide-image-guidelines alert alert-info mb-3">
    <div class="d-flex align-items-start gap-2">
        <i class="fe fe-image fs-18 mt-1"></i>
        <div>
            <strong class="d-block mb-1">Slider image size</strong>
            <span class="d-block">
                Upload slider images at <strong>{{ \App\Models\SliderModel::recommendedSizeLabel() }}</strong> for the best fit on the homepage banner.
            </span>
            <span class="d-block text-muted small mt-2 mb-0">
                Formats: JPG, PNG, WEBP · Max 5MB ·
                Display size: full width × {{ \App\Models\SliderModel::DISPLAY_HEIGHT_DESKTOP }}px (desktop),
                {{ \App\Models\SliderModel::DISPLAY_HEIGHT_MOBILE }}px (mobile)
            </span>
        </div>
    </div>
</div>
