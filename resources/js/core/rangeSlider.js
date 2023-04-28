// range-slider.js
export function calculateValues(
    touchLeftPos,
    touchRightPos,
    sliderWidth,
    touchWidth,
    min,
    max,
    step
) {
    let minValueRatio = touchLeftPos / (sliderWidth - touchWidth);
    let maxValueRatio = touchRightPos / (sliderWidth - touchWidth);
    let minValue = minValueRatio * (max - min) + min;
    let maxValue = maxValueRatio * (max - min) + min;

    if (step !== 0) {
        minValue = Math.round(minValue / step) * step;
        maxValue = Math.round(maxValue / step) * step;
    }

    return { minValue, maxValue };
}

export function setMinValue(minValue, min, max, sliderWidth, touchWidth) {
    let ratio = (minValue - min) / (max - min);
    let touchLeftPos = Math.ceil(ratio * (sliderWidth - touchWidth));
    return touchLeftPos;
}

export function setMaxValue(maxValue, min, max, sliderWidth, touchWidth) {
    let ratio = (maxValue - min) / (max - min);
    let touchRightPos = Math.ceil(ratio * (sliderWidth - touchWidth));
    return touchRightPos;
}
